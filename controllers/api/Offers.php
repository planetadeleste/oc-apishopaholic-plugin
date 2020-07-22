<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;


use Lovata\Shopaholic\Models\Offer;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Offers
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Offers extends Base
{
    public function getModelClass()
    {
        return Offer::class;
    }
}
