<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \PlanetaDelEste\BuddiesGroup\Classes\Item\GroupItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Group
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
        ];
    }

    public function getDataKeys(): array
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

    protected function getEvent(): string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.group';
    }
}
