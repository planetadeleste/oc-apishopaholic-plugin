<?php

namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use ApplicationException;
use Cookie;
use Crypt;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Input;
use JWTAuth;
use Kharanenka\Helper\Result;
use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Components\Registration;
use Lovata\Buddies\Components\ResetPassword;
use Lovata\Buddies\Components\RestorePassword;
use Lovata\Buddies\Facades\AuthHelper;
use Lovata\Buddies\Models\User;
use Lovata\OrdersShopaholic\Models\Cart;
use October\Rain\Argon\Argon;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiToolbox\Classes\Helper\ApiHelper;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;

class Auth extends Base
{
    public const EVENT_API_AFTER_SIGNUP = 'planetadeleste.apiShopaholic.afterSignup';
    public const EVENT_API_SIGNUP_VALID = 'planetadeleste.apiShopaholic.validateSignup';
    public const EVENT_API_AFTER_REFRESH = 'planetadeleste.apiShopaholic.afterRefresh';

    /**
     * @var UserPluginResolver
     */
    protected UserPluginResolver $userPluginResolver;

    /**
     * @var JWTGuard
     */
    protected JWTGuard $JWTGuard;

    /**
     * @param UserPluginResolver $userPluginResolver
     */
    public function __construct(UserPluginResolver $userPluginResolver)
    {
        $this->userPluginResolver = $userPluginResolver;
        $this->JWTGuard           = app('JWTGuard');

        parent::__construct();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $user        = $this->userPluginResolver
                ->getProvider()
                ->authenticate($credentials);

            if (empty($user)) {
                throw new ApplicationException('invalid_credentials');
            }

            $sToken = $this->JWTGuard->login($user);
            $tokenDto = $this->getTokenDto($sToken, $user);
            $arResult = $tokenDto->toArray() + ['expires_in' => $tokenDto->expires];
            $obUser = $arResult['user'];
            $obUserItem = UserItem::make($obUser->id);
            array_set($arResult, 'user', ItemResource::make($obUserItem));

            return response()->json(Result::setTrue($arResult)->get());
        } catch (Exception $e) {
            return static::exceptionResult($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $tokenRefreshed = $this->JWTGuard->refresh(true);
            $this->JWTGuard->setToken($tokenRefreshed);

            $tokenDto = $this->getTokenDto($tokenRefreshed);
            $arResult = $tokenDto->toArray() + ['expires_in' => $tokenDto->expires];
            $obUser = $arResult['user'];
            $obUserItem = UserItem::make($obUser->id);
            array_set($arResult, 'user', ItemResource::make($obUserItem));
            $this->fireSystemEvent(self::EVENT_API_AFTER_REFRESH, [$tokenDto->expires, $tokenDto->token]);

            return response()->json(Result::setTrue($arResult)->get());
        } catch (Exception $e) {
            // something went wrong
            Result::setFalse()->setMessage('could_not_refresh_token');
            return response()->json(Result::get(), 401);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function invalidate(Request $request): JsonResponse
    {
        try {
            // Logout from session
            AuthHelper::logout();

            // invalidate the token
            $this->JWTGuard->invalidate();
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_invalidate_token'], 401);
        }

        // if no errors we can return a message to indicate that the token was invalidated
        return response()->json('token_invalidated');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function signup(Request $request): JsonResponse
    {
        try {
            $obCart = null;

            $this->fireSystemEvent(self::EVENT_API_SIGNUP_VALID, [$request->all()]);
            if (!Result::status()) {
                return response()->json(Result::get(), 401);
            }

            // Check for OrdersShopaholic plugin
            if ($this->hasPlugin('Lovata.OrdersShopaholic')) {
                /** @var Cart $obCart */

                // Load current cart
                $iCartID = Cookie::get(CartProcessor::COOKIE_NAME);
                if (!empty($iCartID) && !is_numeric($iCartID)) {
                    try {
                        $iDecryptedCartID = Crypt::decryptString($iCartID);
                        if (!empty($iDecryptedCartID)) {
                            $iCartID = $iDecryptedCartID;
                        }
                    } catch (Exception $obException) {
                    }
                }

                if (!empty($iCartID)) {
                    $obCart = Cart::with('position')->find($iCartID);
                }
            }

            /** @var Registration $obComponent */
            $obComponent = $this->component(
                Registration::class,
                null,
                ['activation' => 'activation_on', 'force_login' => true]
            );
            $obUserModel = $obComponent->registration($request->all());
            if (!$obUserModel) {
                return response()->json(Result::get(), 401);
            }

            $user = ItemResourceUser::make($obUserModel)->toArray(request());

            // If cart exists, update user_id property
            if ($obCart) {
                $obCart->user_id = $obUserModel->id;
                $obCart->save();
            }
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 401);
        }

        $obAuthUser = User::find($obUserModel->id);
        $token      = JWTAuth::fromUser($obAuthUser);
        $ttl        = config('jwt.ttl');
        $expires_in = $ttl * 60;
        Result::setData(compact('token', 'user', 'expires_in'));

        $this->fireSystemEvent(self::EVENT_API_AFTER_SIGNUP, [$obUserModel, $token]);

        return response()->json(Result::get());
    }

    /**
     * @return JsonResponse
     */
    public function restorePassword(): JsonResponse
    {
        try {
            /** @var RestorePassword $obComponent */
            $obComponent = $this->component(RestorePassword::class);
            $obComponent->sendRestoreMail(Input::only(['email']));
            return response()->json(Result::get());
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 401);
        }
    }

    public function resetPassword(): JsonResponse
    {
        try {
            /** @var ResetPassword $obComponent */
            $obComponent = $this->component(ResetPassword::class, null, ['slug' => input('slug')]);
            $obComponent->checkResetCode();
            $obComponent->resetPassword(Input::only(['password', 'password_confirmation']));
            return response()->json(Result::get());
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 401);
        }
    }

    public function checkResetCode(string $sSlug): JsonResponse
    {
        try {
            /** @var ResetPassword $obComponent */
            $obComponent = $this->component(ResetPassword::class, null, ['slug' => $sSlug]);
            if (!$obComponent->checkResetCode()) {
                Result::setFalse();
            }

            return response()->json(Result::get());
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 401);
        }
    }

    /**
     * @param string               $sToken
     * @param Authenticatable|null $obUser
     * @return TokenDto
     * @throws Exception
     */
    protected function getTokenDto(string $sToken, Authenticatable $obUser = null): TokenDto
    {
        if (!$obUser) {
            $obUser = $this->JWTGuard->user();
        }

        return new TokenDto([
            'token'   => $sToken,
            'expires' => Argon::createFromTimestamp($this->JWTGuard->getPayload()->get('exp'), ApiHelper::tz()),
            'user'    => $obUser,
        ]);
    }
}
