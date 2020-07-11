<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Order;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\PaymentMethod\ItemResource as ItemResourcePaymentMethod;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Status\ItemResource as ItemResourceStatus;
use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\OrderItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Order
 */
class ItemResource extends BaseResource
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return [
            'shipping_price_value'                => (float)$this->shipping_price_value,
            'old_shipping_price_value'            => (float)$this->old_shipping_price_value,
            'discount_shipping_price_value'       => (float)$this->discount_shipping_price_value,
            'total_price_value'                   => (float)$this->total_price_value,
            'old_total_price_value'               => (float)$this->old_total_price_value,
            'discount_total_price_value'          => (float)$this->discount_total_price_value,
            'position_total_price_value'          => (float)$this->position_total_price_value,
            'old_position_total_price_value'      => (float)$this->old_position_total_price_value,
            'discount_position_total_price_value' => (float)$this->discount_position_total_price_value,
            'status'                              => ItemResourceStatus::make($this->status),
            'payment_method'                      => $this->payment_method
                ? ItemResourcePaymentMethod::make($this->payment_method)
                : null
        ];
    }

    public function getDataKeys()
    {
        return ['id', 'order_number', 'currency_symbol', 'total_price'];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
