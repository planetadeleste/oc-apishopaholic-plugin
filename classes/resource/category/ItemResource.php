<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use Illuminate\Http\Resources\Json\Resource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class itemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\CategoryItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class ItemResource extends BaseResource
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return [
            'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
            'text'          => $this->name,
            'value'         => $this->id,
        ];
    }

    public function getDataKeys()
    {
        return ['id', 'name', 'code', 'slug'];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
