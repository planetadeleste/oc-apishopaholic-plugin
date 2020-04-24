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
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'slug'          => $this->slug,
            'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
            'text'          => $this->name,
            'value'         => $this->id,
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
