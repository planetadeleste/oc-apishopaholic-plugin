<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;
use System\Classes\PluginManager;

/**
 * Class showResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\ProductItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ShowResource extends ItemResource
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return array_merge(
            parent::getData(),
            [
                'active'        => $this->active,
                'description'   => $this->description,
                'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
                'category'      => $this->category ? ItemResourceCategory::make($this->category) : null,
                'images'        => IndexCollectionImages::make(collect($this->images)),
                'property'      => $this->formatProperty()
            ]
        );
    }

    protected function formatProperty()
    {
        $arProperties = [];
        if (PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            $arProperties = $this->property->toSimpleArray();
        }

        return $arProperties;
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}
