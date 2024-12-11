<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;


use Lovata\Shopaholic\Classes\Item\ProductItem;

/**
 * Class ShowResource
 *
 * @mixin ProductItem
 */
class ProductShowResource extends ProductItemResource
{
    /**
     * @return string[]
     */
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
