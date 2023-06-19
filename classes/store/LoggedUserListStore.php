<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;
use PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUser\ListByLoggedStore;
use PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUser\SortingListStore;

/**
 * Class LoggedUserListStore
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Store
 *
 * @property SortingListStore  $sorting
 * @property ListByLoggedStore $logged
 */
class LoggedUserListStore extends AbstractListStore
{
    public const SORT_CREATED_AT_ASC  = 'created_at|asc';
    public const SORT_CREATED_AT_DESC = 'created_at|desc';

    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('sorting', SortingListStore::class);
        $this->addToStoreList('logged', ListByLoggedStore::class);
    }
}
