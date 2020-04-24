<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer;

use Event;
use Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection;
use Lovata\PropertiesShopaholic\Classes\Helper\CommonPropertyHelper;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;
use System\Classes\PluginManager;

/**
 * Class showResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\OfferItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer
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
