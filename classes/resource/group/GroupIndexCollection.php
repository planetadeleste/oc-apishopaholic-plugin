<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Group;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

/**
 * Class IndexCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Group
 */
class GroupIndexCollection extends ResourceCollection
{
    public $collects = GroupShowResource::class;

    /**
     * @param $request
     * @return array|Collection|\JsonSerializable|Arrayable
     */
    public function toArray($request): array|\Illuminate\Support\Collection|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return $this->collection;
    }
}
