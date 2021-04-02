<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use Lovata\OrdersShopaholic\Models\PaymentMethod;

/**
 * Class PaymentMethods
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class PaymentMethods extends Base
{
    public function getModelClass(): string
    {
        return PaymentMethod::class;
    }
}
