<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use Event;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class showResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\CategoryItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
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
                'updated_at'    => $this->updated_at->toDateTimeString(),
                'preview_text'  => $this->preview_text,
                'description'   => $this->description
            ]
        );
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}
