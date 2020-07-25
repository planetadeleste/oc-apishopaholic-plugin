<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\UserAddressItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress
 */
class ShowResource extends ItemResource
{
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
}

