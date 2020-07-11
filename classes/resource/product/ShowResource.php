<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\ProductItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ShowResource extends ItemResource
{
    public function getDataKeys()
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
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}

