<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Models\Brand;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Brands
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Brands extends Base
{
    public function getModelClass(): string
    {
        return Brand::class;
    }

    public function getSortColumn(): ?string
    {
        return 'no';
    }
}
