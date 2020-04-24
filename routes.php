<?php

use PlanetaDelEste\ApiShopaholic\Controllers\Api\Categories;
use PlanetaDelEste\ApiShopaholic\Controllers\Api\Products;
use Tymon\JWTAuth\Middleware\GetUserFromToken;

Route::prefix('api/v1')
    ->middleware('web')
    ->group(
        function () {
            Route::prefix('categories')->group(plugins_path('/planetadeleste/apishopaholic/routes/categories.php'));
            Route::prefix('products')->group(plugins_path('/planetadeleste/apishopaholic/routes/products.php'));
            Route::prefix('cart')->group(plugins_path('/planetadeleste/apishopaholic/routes/cart.php'));

            Route::apiResources(
                [
                    'categories' => Categories::class,
                    'products'   => Products::class
                ]
            );

            // AUTHENTICATE
            Route::prefix('auth')->group(plugins_path('/planetadeleste/apishopaholic/routes/auth.php'));

            Route::group(['middleware' => GetUserFromToken::class], function() {
            });
        }
    );
