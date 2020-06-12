<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cms\Classes\ComponentManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JWTAuth;
use Kharanenka\Helper\Result;
use Lovata\Buddies\Components\Registration;
use Lovata\Buddies\Facades\AuthHelper;
use Lovata\Buddies\Models\User;
use Lovata\OrdersShopaholic\Components\UserAddress;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource;
use Tymon\JWTAuth\Exceptions\JWTException;

class Auth extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
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
            return response()->json(Result::get(), 500);
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
            // invalidate the token
            JWTAuth::invalidate($token);
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_invalidate_token'], 500);
        }

        // if no errors we can return a message to indicate that the token was invalidated
        return response()->json('token_invalidated');
    }

    public function signup()
    {
        try {
            /** @var Registration $obComponent */
            $obComponent = ComponentManager::instance()->makeComponent(
                Registration::class,
                null,
                ['activation' => 'activation_on', 'force_login' => true]
            );
            $obUserModel = $obComponent->registration(post());
            $user = ItemResource::make($obUserModel);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $token = JWTAuth::fromUser($obUserModel);
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;
        $message = Result::message();

        return response()->json(compact('token', 'user', 'expires_in', 'message'));
    }
}
