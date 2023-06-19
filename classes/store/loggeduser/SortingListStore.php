<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUser;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;
use PlanetaDelEste\ApiShopaholic\Models\LoggedUser;
use PlanetaDelEste\ApiToolbox\Traits\Store\SortingListTrait;

/**
 * Class SortingListStore
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUser
 */
class SortingListStore extends AbstractStoreWithParam
{
    use SortingListTrait;

    protected static $instance;

    public $arListFromDB = ['created_at', 'last_activity_at'];

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return LoggedUser::class;
    }
}
