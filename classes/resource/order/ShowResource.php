<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Order;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\PaymentMethod\ItemResource as ItemResourcePaymentMethod;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Status\ItemResource as ItemResourceStatus;
use PlanetaDelEste\ApiShopaholic\Plugin;

class ShowResource extends ItemResource
{
    public function getData()
    {
        return parent::getData() + [
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
        return array_merge(
            parent::getDataKeys(),
            [
                'user_id',
                'status_id',
                'payment_method_id',
                'shipping_type_id',
                'weight',
                'shipping_price',
                'old_shipping_price',
                'discount_shipping_price',
                'old_total_price',
                'discount_total_price',
                'position_total_price',
                'old_position_total_price',
                'discount_position_total_price',
                'property',
                'order_position_id',
                'order_promo_mechanism_id',
                'shipping_tax_percent',
                'secret_key'
            ]
        );
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}
