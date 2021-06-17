<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\CurrencyItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
            'active' => (bool)$this->getObject()->active
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'id',
            'active',
            'is_default',
            'name',
            'code',
            'rate',
            'symbol',
        ];
    }

    protected function getEvent(): string
    {
        // Paste below code in PlanetaDelEste\ApiShopaholic\Plugin class
        // const EVENT_ITEMRESOURCE_DATA = 'planetadeleste.apishopaholic.resource.itemData';
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.currency';
    }
}
