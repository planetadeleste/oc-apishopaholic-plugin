<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Store;

use Lovata\Shopaholic\Classes\Store\ProductListStore as ShopaholicProductListStore;
use PlanetaDelEste\ApiShopaholic\Classes\Store\Product\ListBySlugStore;

/**
 * Class ProductListStore
 *
 * @property ListBySlugStore $slug
 */
class ProductListStore extends ShopaholicProductListStore
{
    /**
     * @var self
     */
    protected static $instance;

    /**
     * Init store method
     * @return void
     */
    protected function init(): void
    {
        parent::init();
        $this->addToStoreList('slug', ListBySlugStore::class);
    }
}
