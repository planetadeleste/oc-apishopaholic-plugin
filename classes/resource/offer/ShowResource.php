<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\OfferItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer
 */
class ShowResource extends ItemResource
{
    public function getDataKeys(): array
    {
        return [
            'active',
            'code',
            'currency',
            'currency_code',
            'description',
            'external_id',
            'height',
            'id',
            'images',
            'length',
            'measure_id',
            'measure_of_unit_id',
            'name',
            'preview_image',
            'preview_text',
            'price',
            'price_value',
            'old_price',
            'old_price_value',
            'product_id',
            'property',
            'quantity',
            'quantity_in_unit',
            'weight',
            'width',
        ];
    }
}

