<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use PlanetaDelEste\ApiToolbox\Classes\Resource\ResourceCollection;

/**
 * Class IndexCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class IndexCollection extends ResourceCollection
{
    public $collects = ShowResource::class;

    public function toArray($request)
    {
        return $this->collection;
    }
}
