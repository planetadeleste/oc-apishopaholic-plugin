<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Order;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Order
 */
class ListCollection extends IndexCollection
{
    public $collects = ItemResource::class;
}
