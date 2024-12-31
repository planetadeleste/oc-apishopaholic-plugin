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
use Kharanenka\Helper\Result;
use Lovata\Buddies\Components\Registration;
use Lovata\Buddies\Components\ResetPassword;
use Lovata\Buddies\Components\RestorePassword;
use Lovata\Buddies\Models\User;
use Lovata\OrdersShopaholic\Classes\Processor\CartProcessor;
use Lovata\OrdersShopaholic\Models\Cart;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiToolbox\classes\Dto\TokenDto;
use PlanetaDelEste\ApiToolbox\Classes\Helper\AuthHelper;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;

class Auth extends Base
{
    public const EVENT_API_AFTER_SIGNUP  = 'planetadeleste.apiShopaholic.afterSignup';
    public const EVENT_API_SIGNUP_VALID  = 'planetadeleste.apiShopaholic.validateSignup';
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

            $arResult = AuthHelper::loginAndReturnResult($user);

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
            $arResult = AuthHelper::dtoData($tokenRefreshed);
            $this->fireSystemEvent(self::EVENT_API_AFTER_REFRESH, [$arResult['expires'], $arResult['token']]);

            return response()->json(Result::setTrue($arResult)->get());
        } catch (Exception $e) {
            // Something went wrong
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
                // Load current cart
                $iCartID = Cookie::get(CartProcessor::COOKIE_NAME);

                if (!empty($iCartID) && !is_numeric($iCartID)) {
                    try {
                        $iDecryptedCartID = Crypt::decryptString($iCartID);

                        if (!empty($iDecryptedCartID)) {
                            $iCartID = $iDecryptedCartID;
                        }
                    } catch (Exception) {
                        // Do nothing here
                    }
                }

                if (!empty($iCartID)) {
                    /** @var Cart | null $obCart */
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

            $user = ItemResource::make($obUserModel)->toArray(request());

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
        $token      = AuthHelper::jwt()->fromUser($obAuthUser);
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
     *
     * @return TokenDto
     *
     * @throws Exception
     */
    protected function getTokenDto(string $sToken, ?Authenticatable $obUser = null): TokenDto
    {
        return AuthHelper::getTokenDto($sToken, $obUser);
    }
}
