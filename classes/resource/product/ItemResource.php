<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

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
 * @mixin \Lovata\Shopaholic\Classes\Item\ProductItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ItemResource extends BaseResource
{
    public function getData(): array
    {
        return [
            'active'          => (bool)$this->active,
            'preview_image'   => $this->preview_image?->getPath(),
            'images'          => IndexCollectionImages::make(collect($this->images)),
            'category'        => ($this->category && $this->category_id) ? ItemResourceCategory::make($this->category) : null,
            'property'        => $this->formatProperty(),
            'category_name'   => $this->category?->name,
            'offers'          => $this->offer->isNotEmpty() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => $this->preview_image?->getThumb(300, 300, ['mode' => 'crop']),
            'secondary_thumb' => $this->images
                ? collect($this->images)->first()->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'brand'           => ($this->brand && $this->brand_id) ? ItemResourceBrand::make($this->brand) : null
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
            'brand_id',
            'preview_text',
            'thumbnail',
            'secondary_thumb',
            'offers',
            'category_name',
        ];
    }

    protected function getEvent(): ?string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA . '.product';
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
