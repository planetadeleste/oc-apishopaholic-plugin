<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Order;

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
            'id',
            'currency_id',
            'discount_position_total_price',
            'discount_position_total_price_value',
            'discount_shipping_price',
            'discount_shipping_price_value',
            'discount_total_price',
            'discount_total_price_value',
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
}

