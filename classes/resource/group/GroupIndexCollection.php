<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use PlanetaDelEste\ApiToolbox\Classes\Resource\ResourceCollection;

/**
 * Class IndexCollection
 */
class GroupIndexCollection extends ResourceCollection
{
    public $collects = GroupShowResource::class;

    /**
     * @param mixed $request
     *
     * @return array|Collection|\JsonSerializable|Arrayable
     */
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection;
    }
}
