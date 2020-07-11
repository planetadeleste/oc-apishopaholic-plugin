<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\BrandItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand
 */
class ShowResource extends ItemResource
{
    public function getDataKeys()
    {
        return [
            'id',
            'active',
            'name',
            'slug',
            'code',
            'external_id',
            'preview_text',
            'description',
            'sort_order',
            'created_at',
            'updated_at',
            'images',
            'preview_image'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}

