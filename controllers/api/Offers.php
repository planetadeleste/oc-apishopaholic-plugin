<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;


use Lovata\Shopaholic\Classes\Store\OfferListStore;
use Lovata\Shopaholic\Models\Offer;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Offers
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Offers extends Base
{
    public function getModelClass(): string
    {
        return Offer::class;
    }

    public function getSortColumn(): string
    {
        return OfferListStore::SORT_NEW;
    }
}
