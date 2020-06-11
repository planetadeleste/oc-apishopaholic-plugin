<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer;

use Event;
use Illuminate\Http\Resources\Json\Resource;
use Lovata\Shopaholic\Classes\Helper\CurrencyHelper;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class itemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\OfferItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer
 */
class ItemResource extends BaseResource
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return [
            'price_value'     => (float)$this->price_value,
            'old_price_value' => (float)$this->old_price_value,
            'currency'        => CurrencyHelper::instance()->getDefault()->symbol,
            'thumbnail'       => $this->preview_image ? $this->preview_image->getThumb(
                300,
                300,
                ['mode' => 'crop']
            ) : null,
            'text' => $this->name,
            'value' => $this->id,
        ];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'name',
            'code',
            'price',
            'old_price',
            'quantity',
            'preview_text'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
