<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ProductItemResource;

class ProductBasicResource extends ProductItemResource
{
    /**
     * @return array<string>
     */
    public function getDataKeys(): array
    {
        return [
            'id',
            'name',
            'code',
            'slug',
            'active',
            'category_id',
            'secondary_thumb',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @return string[]
     */
    public function getColumns(): array
    {
        return ['id', 'active', 'category_id', 'code', 'name', 'slug'];
    }
}