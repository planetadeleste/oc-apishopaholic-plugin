<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Event;
use Illuminate\Http\Resources\Json\Resource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection as IndexCollectionOffer;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class itemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\ProductItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ItemResource extends BaseResource
{
    /**
     * @return array
     */
    public function getData()
    {
        return [
            'category_name'   => $this->category ? $this->category->name : null,
            'offers'          => $this->offer->count() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => $this->preview_image
                ? $this->preview_image->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'secondary_thumb' => $this->images
                ? collect($this->images)->first()->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'text'            => $this->name,
            'value'           => $this->id,
        ];
    }

    public function getDataKeys()
    {
        return ['id', 'name', 'code', 'slug', 'category_id', 'preview_text'];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
