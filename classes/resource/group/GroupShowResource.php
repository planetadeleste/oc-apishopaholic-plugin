<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

use PlanetaDelEste\BuddiesGroup\Classes\Item\GroupItem;

/**
 * Class ShowResource
 *
 * @mixin GroupItem
 */
class GroupShowResource extends GroupItemResource
{
    /**
     * @return string[]
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
}
