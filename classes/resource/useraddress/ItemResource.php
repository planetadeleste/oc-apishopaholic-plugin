<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\UserAddressItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress
 */
class ItemResource extends BaseResource
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return [
        ];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'user_id',
            'type',
            'country',
            'state',
            'city',
            'street',
            'house',
            'building',
            'flat',
            'floor',
            'address1',
            'address2',
            'postcode',
            'created_at',
            'updated_at'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
