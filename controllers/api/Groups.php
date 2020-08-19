<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\Group;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\BuddiesGroup\Classes\Store\GroupListStore;

/**
 * Class Groups
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 * @property \PlanetaDelEste\BuddiesGroup\Classes\Collection\GroupCollection $collection
 */
class Groups extends Base
{
    public $sortColumn = 'name';

    public function getModelClass()
    {
        return Group::class;
    }
}
