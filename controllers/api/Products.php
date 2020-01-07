<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Models\Product;

class Products extends Base
{
    protected $modelClass = Product::class;

    public function extendIndex()
    {
        if ($limit = input('filters[limit]')) {
            $this->collection->take($limit);
        }
    }
}
