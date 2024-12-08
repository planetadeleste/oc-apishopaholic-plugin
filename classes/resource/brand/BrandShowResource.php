<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

use Lovata\Shopaholic\Classes\Item\BrandItem;

/**
 * Class ShowResource
 *
 * @mixin BrandItem
 */
class BrandShowResource extends BrandItemResource
{
    /**
     * @return string[]
     */
    public function getDataKeys(): array
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
}

