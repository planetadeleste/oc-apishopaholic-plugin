<?php

use PlanetaDelEste\ApiShopaholic\Controllers\Api\Categories;
use PlanetaDelEste\ApiShopaholic\Controllers\Api\Products;

Route::prefix('api/v1')->group(
    function () {
        Route::prefix('categories')->group(plugins_path('/planetadeleste/apishopaholic/routes/categories.php'));
        Route::prefix('products')->group(plugins_path('/planetadeleste/apishopaholic/routes/products.php'));

        Route::apiResources(
            [
                'categories' => Categories::class,
                'products'   => Products::class
            ]
        );
    },
    ''
);
