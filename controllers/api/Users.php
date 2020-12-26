<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\User;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\BuddiesGroup\Classes\Store\UserListStore;

/**
 * Class Users
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Users extends Base
{
    protected $arFileList = ['attachOne' => 'avatar'];

    public function getModelClass(): string
    {
        return User::class;
    }

    public function getSortColumn(): ?string
    {
        return UserListStore::SORT_BY_LATEST;
    }
}
