<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer;

use Lovata\Shopaholic\Classes\Helper\CurrencyHelper;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\OfferItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return [
            'preview_image'   => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'          => IndexCollectionImages::make(collect($this->images)),
            'price_value'     => (float)$this->price_value,
            'old_price_value' => (float)$this->old_price_value,
            'currency'        => CurrencyHelper::instance()->getDefault()->symbol,
            'thumbnail'       => $this->preview_image ? $this->preview_image->getThumb(
                300,
                300,
                ['mode' => 'crop']
            ) : null,
            'property'        => $this->formatProperty()
        ];
    }

    public function getDataKeys()
    {
        return [
            'code',
            'currency',
            'currency_code',
            'id',
            'name',
            'preview_image',
            'preview_text',
            'price',
            'price_value',
            'old_price',
            'old_price_value',
            'product_id',
            'quantity',
            'thumbnail'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.offer';
    }
}
