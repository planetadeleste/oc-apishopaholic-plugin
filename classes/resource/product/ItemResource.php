<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand\ItemResource as ItemResourceBrand;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection as IndexCollectionOffer;
use PlanetaDelEste\ApiShopaholic\Plugin;
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
            'preview_image'   => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'          => IndexCollectionImages::make(collect($this->images)),
            'category'        => $this->category ? ItemResourceCategory::make($this->category) : null,
            'property'        => $this->formatProperty(),
            'category_name'   => $this->category ? $this->category->name : null,
            'offers'          => $this->offer->count() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => $this->preview_image
                ? $this->preview_image->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'secondary_thumb' => $this->images
                ? collect($this->images)->first()->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'brand' => $this->brand ? ItemResourceBrand::make($this->brand) : null
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'id',
            'name',
            'code',
            'slug',
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

    protected function formatProperty()
    {
        $arProperties = [];
        if (PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            $arProperties = $this->property->toSimpleArray();
        }

        return $arProperties;
    }
}
