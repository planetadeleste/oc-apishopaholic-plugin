<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cookie;
use Crypt;
use Exception;
use Illuminate\Http\Request;
use Input;
use JWTAuth;
use Kharanenka\Helper\Result;
use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Components\Registration;
use Lovata\Buddies\Components\ResetPassword;
use Lovata\Buddies\Components\RestorePassword;
use Lovata\Buddies\Facades\AuthHelper;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource as ItemResourceUser;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\JWTAuth\Models\User;

class Auth extends Base
{
    public const EVENT_API_AFTER_SIGNUP = 'planetadeleste.apiShopaholic.afterSignup';
    public const EVENT_API_SIGNUP_VALID = 'planetadeleste.apiShopaholic.validateSignup';

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = JWTAuth::attempt($credentials)) {
            Result::setFalse()->setMessage('invalid_credentials');
            return response()->json(Result::get(), 401);
        }

        /** @var \Lovata\Buddies\Models\User $userModel */
        $userModel = JWTAuth::setToken($token)->authenticate();
        AuthHelper::authenticate($credentials, true);
        $obUserItem = UserItem::make($userModel->id);
        $user = $userModel ? ItemResourceUser::make($obUserItem)->toArray(request()) : [];
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;

        // if no errors are encountered we can return a JWT
        Result::setTrue(compact('token', 'user', 'expires_in'));
        return response()->json(Result::get());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        try {
            // attempt to refresh the JWT
            if (!$token = JWTAuth::refresh()) {
                AuthHelper::logout();
                Result::setFalse()->setMessage('could_not_refresh_token');
                return response()->json(Result::get(), 401);
            }
        } catch (Exception $e) {
            // something went wrong
            Result::setFalse()->setMessage('could_not_refresh_token');
            return response()->json(Result::get(), 401);
        }

        // if no errors are encountered we can return a new JWT
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;
        Result::setTrue(compact('token', 'expires_in'));
        return response()->json(Result::get());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidate(Request $request)
    {
        try {
            // Logout from session
            AuthHelper::logout();

            // invalidate the token
            JWTAuth::invalidate();
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_invalidate_token'], 401);
        }

        // if no errors we can return a message to indicate that the token was invalidated
        return response()->json('token_invalidated');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $obCart = null;

            $this->fireSystemEvent(self::EVENT_API_SIGNUP_VALID, [$request->all()]);
            if (!Result::status()) {
                return response()->json(Result::get(), 401);
            }

            // Check for OrdersShopaholic plugin
            if ($this->hasPlugin('Lovata.OrdersShopaholic')) {
                /** @var \Lovata\OrdersShopaholic\Models\Cart $obCart */

                // Load current cart
                $iCartID = Cookie::get(\Lovata\OrdersShopaholic\Classes\Processor\CartProcessor::COOKIE_NAME);
                if (!empty($iCartID) && !is_numeric($iCartID)) {
                    try {
                        $iDecryptedCartID = Crypt::decryptString($iCartID);
                        if (!empty($iDecryptedCartID)) {
                            $iCartID = $iDecryptedCartID;
                        }
                    } catch (\Exception $obException) {
                    }
                }

                if (!empty($iCartID)) {
                    $obCart = \Lovata\OrdersShopaholic\Models\Cart::with('position')->find($iCartID);
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
        $token = JWTAuth::fromUser($obAuthUser);
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;
        Result::setData(compact('token', 'user', 'expires_in'));

        $this->fireSystemEvent(self::EVENT_API_AFTER_SIGNUP, [$obUserModel, $token]);

        return response()->json(Result::get());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function restorePassword()
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

    public function resetPassword()
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

    public function checkResetCode()
    {
        try {
            /** @var ResetPassword $obComponent */
            $obComponent = $this->component(ResetPassword::class, null, ['slug' => input('slug')]);
            if (!$obComponent->checkResetCode()) {
                Result::setFalse();
            }

            return response()->json(Result::get());
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 401);
        }
    }
}
