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
    /**
     * @var array<string>
     */
    protected $casts = ['active' => 'bool'];

    /**
     * @return array<\Closure>
     */
    public function getData(): array
    {
        return [
            'preview_image'   => fn() => $this->preview_image?->getPath(),
            'images'          => fn() => IndexCollectionImages::make(collect($this->images)),
            'category'        => fn() => ($this->category && $this->category_id) ? ItemResourceCategory::make($this->category) : null,
            'property'        => fn() => $this->formatProperty(),
            'category_name'   => fn() => $this->category?->name,
            'offers'          => fn() => $this->offer->isNotEmpty() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => fn() => $this->preview_image?->getThumb(300, 300, ['mode' => 'crop']),
            'secondary_thumb' => fn() => count($this->images)
                ? collect($this->images)->first()->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'brand'           => fn() => ($this->brand && $this->brand_id) ? ItemResourceBrand::make($this->brand) : null
        ];
    }

    /**
     * @return array<string>
     */
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

    public function getColumns(): array
    {
        if (input('filters.response', 'full') === 'compact') {
            return ['id', 'active', 'category_id', 'code', 'name', 'slug'];
        }

        return [];
    }

    /**
     * @return string|null
     */
    protected function getEvent(): ?string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.product';
    }

    /**
     * @return array
     */
    protected function formatProperty(): array
    {
        $arProperties = [];

        if (PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            $arProperties = is_array($this->property) ? $this->property : $this->property->toSimpleArray();
        }

        return $arProperties;
    }
}
