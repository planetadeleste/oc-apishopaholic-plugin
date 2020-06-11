<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Address;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexCollection extends ResourceCollection
{
    public $collects = ItemResource::class;

    public function toArray($request)
    {
        return $this->collection;
    }
}
