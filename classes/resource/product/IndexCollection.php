<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexCollection extends ResourceCollection
{
    public $collects = ShowResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
