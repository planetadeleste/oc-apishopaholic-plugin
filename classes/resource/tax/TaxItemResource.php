<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\TaxItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax
 */
class TaxItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData(): array
    {
        return [
            'active'    => (bool)$this->active,
            'is_global' => (bool)$this->is_global,
            'percent'   => (float)$this->percent,
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'id',
            'is_global',
            'active',
            'name',
            'percent',
            'description',
            'sort_order',
        ];
    }

    protected function getEvent(): string
    {
        // Paste below code in PlanetaDelEste\ApiShopaholic\Plugin class
        // const EVENT_ITEMRESOURCE_DATA = 'planetadeleste.apishopaholic.resource.itemData';
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.tax';
    }
}
