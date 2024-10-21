<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency;

use Lovata\Shopaholic\Classes\Item\CurrencyItem;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin CurrencyItem
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
            'active'      => (bool) $this->active,
            'external_id' => (int) $this->external_id,
        ];
    }

    /**
     * @return string[]
     */
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

    /**
     * @return string
     */
    protected function getEvent(): string
    {
        // Paste below code in PlanetaDelEste\ApiShopaholic\Plugin class
        // const EVENT_ITEMRESOURCE_DATA = 'planetadeleste.apishopaholic.resource.itemData';
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.currency';
    }
}
