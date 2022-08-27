<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class IndexCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax
 */
class TaxIndexCollection extends ResourceCollection
{
    public $collects = TaxShowResource::class;

    public function toArray($request)
    {
        return $this->collection;
    }
}
