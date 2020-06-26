<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class ListCollection extends IndexCollection
{
    public $collects = ItemResource::class;
}
