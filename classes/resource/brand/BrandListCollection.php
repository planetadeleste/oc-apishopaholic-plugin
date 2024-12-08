<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand
 */
class BrandListCollection extends BrandIndexCollection
{
    public $collects = BrandItemResource::class;
}
