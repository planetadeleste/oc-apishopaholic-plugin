<?php use PlanetaDelEste\ApiShopaholic\Plugin;

Route::prefix('api/v1')
    ->namespace('PlanetaDelEste\ApiShopaholic\Controllers\Api')
    ->middleware(['throttle:120,1', 'bindings'])
    ->group(
        function () {
            $arRoutes = [
                'auth',
                'brands',
                'categories',
                'currencies',
                'files',
                'groups',
                'lang',
                'offers',
                'products',
                'profile',
                'taxes',
                'users',
            ];

            foreach ($arRoutes as $sPublicRoute) {
                Route::group([], plugins_path(Plugin::API_ROUTES.$sPublicRoute.'.php'));
            }
        }
    );
