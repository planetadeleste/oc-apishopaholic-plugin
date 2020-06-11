<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Order;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\OrderItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Order
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
     * @inheritDoc
     */
    public function getData()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getDataKeys()
    {
        return ['id', 'order_number', 'currency_symbol', 'total_price'];
    }
}
