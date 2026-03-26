<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use PlanetaDelEste\ApiToolbox\Classes\Resource\ResourceCollection;

/**
 * Class IndexCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand
 */
class BrandIndexCollection extends ResourceCollection
{
    public $collects = BrandShowResource::class;

    /**
     * @param mixed $request
     *
     * @return array|Arrayable|Collection|\JsonSerializable
     */
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection;
    }
}
