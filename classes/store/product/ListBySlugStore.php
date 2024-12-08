<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Store\Product;

use Lovata\Shopaholic\Models\Product;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;

class ListBySlugStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * @inheritDoc
     */
    protected function getIDListFromDB(): array
    {
        return Product::getBySlug($this->sValue)->pluck('id')->all();
    }
}