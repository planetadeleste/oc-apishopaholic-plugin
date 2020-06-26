<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ListCollection extends IndexCollection
{
    public $collects = ItemResource::class;
}
