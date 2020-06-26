<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Models\Product;

class Products extends Base
{
    public function extendIndex()
    {
        if ($limit = input('filters[limit]')) {
            $this->collection->take($limit);
        }
    }

    public function getModelClass()
    {
        return Product::class;
    }
}
