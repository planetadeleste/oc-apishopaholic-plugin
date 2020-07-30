<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cookie;
use Crypt;
use Exception;
use Illuminate\Http\Request;
use Input;
use JWTAuth;
use Kharanenka\Helper\Result;
use Lovata\Buddies\Components\Registration;
use Lovata\Buddies\Components\ResetPassword;
use Lovata\Buddies\Components\RestorePassword;
use Lovata\Buddies\Facades\AuthHelper;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

class Auth extends Base
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        /** @var \Lovata\Buddies\Models\User $userModel */
        $userModel = JWTAuth::authenticate($token);
        AuthHelper::authenticate($credentials, true);
        $user = $userModel ? ItemResource::make($userModel) : [];
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token', 'user', 'expires_in'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $token = $request->get('token');

        try {
            // attempt to refresh the JWT
            if (!$token = JWTAuth::refresh($token)) {
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
        $token = $request->get('token');

        try {
            // Logout from session
            AuthHelper::logout();
            if (!$token) {
                Result::setFalse()->setMessage('could_not_invalidate_token');
                return response()->json(Result::get(), 401);
            }
            // invalidate the token
            JWTAuth::invalidate($token);
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_invalidate_token'], 401);
        }

        // if no errors we can return a message to indicate that the token was invalidated
        return response()->json('token_invalidated');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup()
    {
        try {
            $obCart = null;

            // Check for OrdersShopaholic plugin
            if ($this->hasPlugin('Lovata.OrdersShopaholic')) {

                /** @var Lovata\OrdersShopaholic\Models\Cart $obCart */
                // Load current cart
                $iCartID = Cookie::get(Lovata\OrdersShopaholic\Classes\Processor\CartProcessor::COOKIE_NAME);
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
                    $obCart = Lovata\OrdersShopaholic\Models\Cart::with('position')->find($iCartID);
                }
            }

            /** @var Registration $obComponent */
            $obComponent = $this->component(
                Registration::class,
                null,
                ['activation' => 'activation_on', 'force_login' => true]
            );
            $obUserModel = $obComponent->registration(post());
            if (!$obUserModel) {
                return response()->json(Result::get(), 401);
            }

            $user = ItemResource::make($obUserModel);

            // If cart exists, update user_id property
            if ($obCart) {
                $obCart->user_id = $obUserModel->id;
                $obCart->save();
            }
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 401);
        }

        $token = JWTAuth::fromUser($obUserModel);
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;
        Result::setData(compact('token', 'user', 'expires_in'));

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
