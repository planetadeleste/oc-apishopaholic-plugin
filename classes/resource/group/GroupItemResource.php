<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;
use PlanetaDelEste\BuddiesGroup\Classes\Item\GroupItem;

/**
 * Class ItemResource
 *
 * @mixin GroupItem
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Group
 */
class GroupItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
        ];
    }

    /**
     * @return array<string>
     */
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

    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.group';
    }
}
