<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\OrderPosition;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\ItemResource as ItemResourceOffer;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\OrderPositionItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\OrderPosition
 */
class ItemResource extends BaseResource
{

    /**
     * @inheritDoc
     */
    protected function getEvent()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return [
            'offer' => ItemResourceOffer::make($this->offer)
        ];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'order_id',
            'quantity',
            'weight',
            'height',
            'length',
            'width',
        ];
    }
}
