<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use PlanetaDelEste\ApiToolbox\Classes\Resource\ResourceCollection;

/**
 * Class IndexCollection
 */
class ProductIndexCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = ProductShowResource::class;

    /**
     * @param $request
     *
     * @return array|Arrayable|Collection|\JsonSerializable
     */
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        if (input('filters.response', 'full') !== 'compact') {
            return;
        }

        $this->collects = ProductBasicResource::class;
    }
}
