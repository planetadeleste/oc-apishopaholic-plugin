<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Address;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\UserAddressItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Address
 */
class ItemResource extends BaseResource
{

    /**
     * @inheritDoc
     */
    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
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
        ];
    }
}
