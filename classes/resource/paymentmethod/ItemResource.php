<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\PaymentMethod;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\PaymentMethodItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\PaymentMethod
 */
class ItemResource extends BaseResource
{

    /**
     * @inheritDoc
     */
    protected function getEvent()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return [];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'name',
            'code',
            'preview_text',
            'restriction',
        ];
    }
}
