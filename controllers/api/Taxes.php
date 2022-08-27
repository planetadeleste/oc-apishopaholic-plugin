<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax\TaxIndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax\TaxListCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax\TaxShowResource;
use Lovata\Shopaholic\Models\Tax;

/**
 * Class Taxes
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Taxes extends Base
{
    public function getModelClass(): string
    {
        return Tax::class;
    }

    public function getSortColumn(): string
    {
        return 'sort';
    }

    public function getShowResource(): string
    {
        return TaxShowResource::class;
    }

    public function getIndexResource(): string
    {
        return TaxIndexCollection::class;
    }

    public function getListResource(): string
    {
        return TaxListCollection::class;
    }
}
