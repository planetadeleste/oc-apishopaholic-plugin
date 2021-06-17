<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use Lovata\Shopaholic\Models\Currency;

/**
 * Class Currencies
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Currencies extends Base
{
    public function getModelClass(): string
    {
        return Currency::class;
    }

    public function getSortColumn(): string
    {
        return 'sort';
    }
}
