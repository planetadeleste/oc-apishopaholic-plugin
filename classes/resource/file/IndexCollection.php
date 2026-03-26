<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\File;

use PlanetaDelEste\ApiToolbox\Classes\Resource\ResourceCollection;

class IndexCollection extends ResourceCollection
{
    public $collects = ItemResource::class;

    public function toArray($request)
    {
        return $this->collection;
    }
}
