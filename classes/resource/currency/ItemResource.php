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
    protected $casts = [
        'active' => 'bool',
        'external_id' => 'int'
    ];

    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [];
    }

    public function getDataKeys(): array
    {
        return [
            'id',
            'external_id',
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
