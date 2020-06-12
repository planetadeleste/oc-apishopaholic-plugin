<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\OrderPosition;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\ItemResource as ItemResourceOffer;

class ShowResource extends ItemResource
{
    public function getData()
    {
        return parent::getData() + [
                'offer' => ItemResourceOffer::make($this->offer)
            ];
    }

    public function getDataKeys()
    {
        return array_merge(
            parent::getDataKeys(),
            [
                'price',
                'price_value',
                'tax_price',
                'tax_price_value',
                'price_without_tax',
                'price_without_tax_value',
                'price_with_tax',
                'price_with_tax_value',
                'old_price',
                'old_price_value',
                'tax_old_price',
                'tax_old_price_value',
                'old_price_without_tax',
                'old_price_without_tax_value',
                'old_price_with_tax',
                'old_price_with_tax_value',
                'total_price',
                'total_price_value',
                'tax_total_price',
                'tax_total_price_value',
                'total_price_without_tax',
                'total_price_without_tax_value',
                'total_price_with_tax',
                'total_price_with_tax_value',
                'old_total_price',
                'old_total_price_value',
                'tax_old_total_price',
                'tax_old_total_price_value',
                'old_total_price_without_tax',
                'old_total_price_without_tax_value',
                'old_total_price_with_tax',
                'old_total_price_with_tax_value',
                'discount_total_price',
                'discount_total_price_value',
                'tax_discount_total_price',
                'tax_discount_total_price_value',
                'discount_total_price_without_tax',
                'discount_total_price_without_tax_value',
                'discount_total_price_with_tax',
                'discount_total_price_with_tax_value',
                'increase_total_price',
                'increase_total_price_value',
                'tax_increase_total_price',
                'tax_increase_total_price_value',
                'increase_total_price_without_tax',
                'increase_total_price_without_tax_value',
                'increase_total_price_with_tax',
                'increase_total_price_with_tax_value',
                'total_price_per_unit',
                'total_price_per_unit_value',
                'tax_total_price_per_unit',
                'tax_total_price_per_unit_value',
                'total_price_per_unit_without_tax',
                'total_price_per_unit_without_tax_value',
                'total_price_per_unit_with_tax',
                'total_price_per_unit_with_tax_value',
                'old_total_price_per_unit',
                'old_total_price_per_unit_value',
                'tax_old_total_price_per_unit',
                'tax_old_total_price_per_unit_value',
                'old_total_price_per_unit_without_tax',
                'old_total_price_per_unit_without_tax_value',
                'old_total_price_per_unit_with_tax',
                'old_total_price_per_unit_with_tax_value',
                'discount_total_price_per_unit',
                'discount_total_price_per_unit_value',
                'tax_discount_total_price_per_unit',
                'tax_discount_total_price_per_unit_value',
                'discount_total_price_per_unit_without_tax',
                'discount_total_price_per_unit_without_tax_value',
                'discount_total_price_per_unit_with_tax',
                'discount_total_price_per_unit_with_tax_value',
                'increase_total_price_per_unit',
                'increase_total_price_per_unit_value',
                'tax_increase_total_price_per_unit',
                'tax_increase_total_price_per_unit_value',
                'increase_total_price_per_unit_without_tax',
                'increase_total_price_per_unit_without_tax_value',
                'increase_total_price_per_unit_with_tax',
                'increase_total_price_per_unit_with_tax_value',
                'tax_percent',
                'code',
                'currency_symbol',
                'currency_code',
            ]
        );
    }
}
