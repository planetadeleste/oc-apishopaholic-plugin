<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use PlanetaDelEste\ApiToolbox\Classes\Resource\ResourceCollection;

/**
 * Class IndexCollection
 */
class CurrencyIndexCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = CurrencyShowResource::class;

    /**
     * @param $request
     *
     * @return array|Arrayable|Collection|\JsonSerializable
     */
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection;
    }
}
