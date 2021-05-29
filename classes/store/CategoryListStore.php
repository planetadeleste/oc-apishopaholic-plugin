<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;
use PlanetaDelEste\ApiShopaholic\Classes\Store\Category\RootListStore;
use PlanetaDelEste\ApiShopaholic\Classes\Store\Category\SortingListStore;

/**
 * Class CategoryListStore
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Store
 *
 * @property SortingListStore $sorting
 * @property RootListStore    $root
 */
class CategoryListStore extends AbstractListStore
{
    const SORT_CREATED_AT_ASC = 'created_at|asc';
    const SORT_CREATED_AT_DESC = 'created_at|desc';

    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('sorting', SortingListStore::class);
        $this->addToStoreList('root', RootListStore::class);
    }
}
