<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Lovata\Shopaholic\Classes\Item\ProductItem;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand\ItemResource as ItemResourceBrand;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection as IndexCollectionOffer;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use System\Classes\PluginManager;

/**
 * Class ItemResource
 *
 * @mixin ProductItem
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ItemResource extends BaseResource
{
    public function getData(): array
    {
        return [
            'active'          => fn() => (bool) $this->active,
            'preview_image'   => fn() => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'          => fn() => IndexCollectionImages::make(collect($this->images)),
            'category'        => fn() => $this->category ? ItemResourceCategory::make($this->category) : null,
            'property'        => fn() => $this->formatProperty(),
            'category_name'   => fn() => $this->category ? $this->category->name : null,
            'offers'          => fn() => $this->offer->count() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => fn() => $this->preview_image
                ? $this->preview_image->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'secondary_thumb' => fn() => $this->images
                ? collect($this->images)->first()->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'brand'           => fn() => $this->brand ? ItemResourceBrand::make($this->brand) : null
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'id',
            'name',
            'code',
            'slug',
            'active',
            'category_id',
            'preview_text',
            'thumbnail',
            'secondary_thumb',
            'offers',
            'category_name',
        ];
    }

    protected function getEvent(): ?string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.product';
    }

    protected function formatProperty(): array
    {
        $arProperties = [];

        if (PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            $arProperties = $this->property->toSimpleArray();
        }

        return $arProperties;
    }
}
