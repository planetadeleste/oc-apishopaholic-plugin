<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand
 */
class ListCollection extends IndexCollection
{
    public $collects = ItemResource::class;
}
