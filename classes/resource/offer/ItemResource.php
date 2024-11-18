<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer;

use Lovata\Shopaholic\Classes\Helper\CurrencyHelper;
use Lovata\Shopaholic\Classes\Item\OfferItem;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin   OfferItem
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
            'active'          => fn() => (bool) $this->active,
            'preview_image'   => fn() => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'          => fn() => IndexCollectionImages::make(collect($this->images)),
            'price_value'     => fn() => (float) $this->price_value,
            'old_price_value' => fn() => (float) $this->old_price_value,
            'currency'        => static fn() => CurrencyHelper::instance()->getDefault()->symbol,
            'thumbnail'       => fn() => $this->preview_image ? $this->preview_image->getThumb(
                300,
                300,
                ['mode' => 'crop']
            ) : null,
            'property'        => fn() => $this->formatProperty()
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'active',
            'code',
            'currency',
            'currency_code',
            'id',
            'name',
            'old_price',
            'old_price_value',
            'preview_image',
            'preview_text',
            'price',
            'price_value',
            'product_id',
            'quantity',
            'thumbnail',
        ];
    }

    protected function getEvent(): string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.offer';
    }
}
