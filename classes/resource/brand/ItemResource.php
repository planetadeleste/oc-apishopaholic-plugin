<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\BrandItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
            'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'        => IndexCollectionImages::make(collect($this->images)),
            'active'        => (bool)$this->active
        ];
    }

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
