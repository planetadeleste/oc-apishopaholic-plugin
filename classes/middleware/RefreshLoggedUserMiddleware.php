<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Middleware;

use Illuminate\Http\Request;
use PlanetaDelEste\ApiShopaholic\Models\LoggedUser;
use PlanetaDelEste\ApiToolbox\Classes\Helper\AuthHelper;

class RefreshLoggedUserMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            if (AuthHelper::check() && ($obUser = AuthHelper::user())) {
                cache()->remember("user.activity.{$obUser->id}", 30, function () use ($obUser) {
                    /** @var LoggedUser $obLoggedUser */
                    $obLoggedUser                   = LoggedUser::firstOrNew(['user_id' => $obUser->id]);
                    $obLoggedUser->last_activity_at = $obLoggedUser->freshTimestamp();
                    $obLoggedUser->forceSave();

                    return $obLoggedUser->last_activity_at->toDateTimeString();
                });
            }
        } catch (\Exception $e) {
            trace_log($e);
        } finally {
            return $next($request);
        }
    }
}
