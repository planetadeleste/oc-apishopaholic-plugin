<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Store\Category;

use Lovata\Shopaholic\Models\Category;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;

class RootListStore extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * @inheritDoc
     */
    protected function getIDListFromDB(): array
    {
        return Category::active()->whereNull('parent_id')->orWhere('parent_id', '0')->lists('id');
    }
}
