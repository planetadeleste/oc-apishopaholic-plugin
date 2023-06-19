<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;
use PlanetaDelEste\ApiShopaholic\Classes\Store\User\ListByLoggedStore;

/**
 * Class UserListStore
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Store
 * @property ListByLoggedStore $logged
 */
class UserListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('logged', ListByLoggedStore::class);
    }
}
