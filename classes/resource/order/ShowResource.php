<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Order;

use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\OrderItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Order
 */
class ShowResource extends ItemResource
{
    public function getDataKeys()
    {
        return [
            'currency_id',
            'discount_position_total_price',
            'discount_position_total_price_value',
            'discount_shipping_price',
            'discount_shipping_price_value',
            'discount_total_price',
            'discount_total_price_value',
            'id',
            'old_position_total_price',
            'old_position_total_price_value',
            'old_shipping_price',
            'old_shipping_price_value',
            'old_total_price',
            'old_total_price_value',
            'order_number',
            'order_position_id',
            'order_promo_mechanism_id',
            'payment_data',
            'payment_method',
            'payment_method_id',
            'payment_response',
            'payment_token',
            'position_total_price',
            'position_total_price_value',
            'property',
            'secret_key',
            'shipping_price',
            'shipping_price_value',
            'shipping_tax_percent',
            'shipping_type_id',
            'status',
            'status_id',
            'total_price_value',
            'transaction_id',
            'user_id',
            'weight',
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}

