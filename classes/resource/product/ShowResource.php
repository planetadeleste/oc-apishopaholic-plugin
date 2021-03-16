<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\ProductItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ShowResource extends ItemResource
{
    public function getDataKeys(): array
    {
        return [
            'active',
            'brand_id',
            'category_id',
            'category_name',
            'category',
            'code',
            'description',
            'external_id',
            'id',
            'images',
            'name',
            'offers',
            'preview_image',
            'preview_text',
            'property',
            'secondary_thumb',
            'slug',
            'thumbnail',
            'brand'
        ];
    }
}

