<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ShowResource
 *
 * @mixin \PlanetaDelEste\BuddiesGroup\Classes\Item\GroupItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Group
 */
class ShowResource extends ItemResource
{
    public function getDataKeys()
    {
        return [
            'id',
            'name',
            'code',
            'description',
            'created_at',
            'updated_at'
        ];
    }
}

