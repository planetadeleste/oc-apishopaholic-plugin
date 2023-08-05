<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\Group;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\GroupCollection;
use PlanetaDelEste\BuddiesGroup\Classes\Store\GroupListStore;

/**
 * Class Groups
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 * @property GroupCollection $collection
 */
class Groups extends Base
{
    public function getModelClass(): string
    {
        return Group::class;
    }

    public function getSortColumn(): string
    {
        return GroupListStore::SORT_NAME_ASC;
    }
}
