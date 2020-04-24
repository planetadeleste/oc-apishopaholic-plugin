<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JWTAuth;
use Lovata\Buddies\Models\User;
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
                return response()->json(['error' => 'could_not_refresh_token'], 401);
            }
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_refresh_token'], 500);
        }

        // if no errors are encountered we can return a new JWT
        $ttl = config('jwt.ttl');
        $expires_in = $ttl * 60;
        return response()->json(compact('token', 'expires_in'));
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
            // invalidate the token
            JWTAuth::invalidate($token);
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_invalidate_token'], 500);
        }

        // if no errors we can return a message to indicate that the token was invalidated
        return response()->json('token_invalidated');
    }

    public function signup(Request $request)
    {
        $credentials = $request->only(['email', 'password', 'password_confirmation']);

        try {
            $userModel = User::create($credentials);
            $user = ItemResource::make($userModel);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $token = JWTAuth::fromUser($userModel);

        return response()->json(compact('token', 'user'));
    }
}
