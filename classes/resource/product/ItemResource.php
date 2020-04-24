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
            'id'              => $this->id,
            'name'            => $this->name,
            'code'            => $this->code,
            'slug'            => $this->slug,
            'category_id'     => $this->category_id,
            'category_name'   => $this->category ? $this->category->name : null,
            'preview_text'    => $this->preview_text,
            'offers'          => $this->offer->count() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => $this->preview_image ? $this->preview_image->getThumb(
                300,
                300,
                ['mode' => 'crop']
            ) : null,
            'secondary_thumb' => count($this->images) ? collect($this->images)->first()->getThumb(
                300,
                300,
                ['mode' => 'crop']
            ) : null,
            'text'            => $this->name,
            'value'           => $this->id,
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
