<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Classes\Store\ProductListStore;
use Lovata\Shopaholic\Models\Product;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

class Products extends Base
{
    public function extendIndex()
    {
        if ($limit = input('filters[limit]')) {
            $this->collection->take($limit);
        }
    }

    public function getModelClass(): string
    {
        return Product::class;
    }

    public function getSortColumn(): string
    {
        return ProductListStore::SORT_NEW;
    }
}
