<?php

use PlanetaDelEste\ApiShopaholic\Plugin;
use System\Classes\PluginManager;

Route::prefix('api/v1')
    ->namespace('PlanetaDelEste\ApiShopaholic\Controllers\Api')
    ->middleware(['throttle:120,1', 'bindings'])
    ->group(
        function () {
            $bHasOrdersPlugin = PluginManager::instance()->hasPlugin('Lovata.OrdersShopaholic');
            $bHasJWTAuthPlugin = PluginManager::instance()->hasPlugin('PlanetaDelEste.JWTAuth');

            Route::prefix('categories')
                ->name('categories.')
                ->group(plugins_path(Plugin::API_ROUTES.'categories.php'));

            Route::prefix('products')
                ->name('products.')
                ->group(plugins_path(Plugin::API_ROUTES.'products.php'));

            // ORDERS
            if ($bHasOrdersPlugin) {
                Route::prefix('cart')
                    ->name('cart.')
                    ->group(plugins_path(Plugin::API_ROUTES.'cart.php'));

                Route::prefix('orders')
                    ->name('orders.')
                    ->group(plugins_path(Plugin::API_ROUTES.'orders_public.php'));
            }

            // TRANSLATE
            Route::prefix('lang')
                ->name('lang.')
                ->group(plugins_path(Plugin::API_ROUTES.'lang.php'));

            Route::apiResource('categories', 'Categories', ['only' => ['index', 'show']]);
            Route::apiResource('products', 'Products', ['only' => ['index', 'show']]);
            Route::apiResource('groups', 'Groups', ['only' => ['index', 'show']]);
            Route::apiResource('brands', 'Brands', ['only' => ['index', 'show']]);

            if ($bHasJWTAuthPlugin) {
                // AUTHENTICATE
                Route::prefix('auth')
                    ->name('auth.')
                    ->group(plugins_path(Plugin::API_ROUTES.'auth.php'));

                Route::middleware(['jwt.auth'])
                    ->group(
                        function () use ($bHasOrdersPlugin) {
                            if ($bHasOrdersPlugin) {
                                Route::prefix('orders')->group(plugins_path(Plugin::API_ROUTES.'orders.php'));
                                Route::apiResource('orders', 'Orders', ['only' => ['store', 'update', 'destroy']]);
                            }

                            Route::prefix('profile')->group(plugins_path(Plugin::API_ROUTES.'profile.php'));
                            Route::apiResource('profile', 'Profile');

                            Route::apiResource('products', 'Products', ['only' => ['store', 'update', 'destroy']]);
                            Route::apiResource('users', 'Users');
                            Route::apiResource('categories', 'Categories', ['only' => ['store', 'update', 'destroy']]);
                            Route::apiResource('files', 'Files', ['only' => ['store', 'update', 'destroy']]);
                            Route::apiResource('offers', 'Offers', ['only' => ['store', 'update', 'destroy']]);
                            Route::apiResource('groups', 'Groups', ['only' => ['store', 'update', 'destroy']]);
                            Route::apiResource('brands', 'Brands', ['only' => ['store', 'update', 'destroy']]);
                        }
                    );
            }
        }
    );
