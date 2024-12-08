<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Group
 */
class GroupListCollection extends GroupIndexCollection
{
    public $collects = GroupItemResource::class;
}
