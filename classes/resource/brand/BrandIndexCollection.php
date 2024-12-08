<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

/**
 * Class IndexCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand
 */
class BrandIndexCollection extends ResourceCollection
{
    public $collects = BrandShowResource::class;

    /**
     * @param $request
     * @return array|Arrayable|Collection|\JsonSerializable
     */
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection;
}
}
