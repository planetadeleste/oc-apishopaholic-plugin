<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

use Lovata\Shopaholic\Classes\Item\BrandItem;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin BrandItem
 */
class BrandItemResource extends Base
{
    /**
     * @var array<string>
     */
    protected $casts = ['active' => 'bool'];

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'preview_image' => fn() => $this->preview_image?->getPath(),
            'images'        => fn() => IndexCollectionImages::make(collect($this->images)),
        ];
    }

    /**
     * @return array<string>
     */
    public function getDataKeys(): array
    {
        return [
            'id',
            'active',
            'name',
            'slug',
            'code',
            'preview_image'
        ];
    }

    protected function getEvent(): string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.brand';
    }
}
