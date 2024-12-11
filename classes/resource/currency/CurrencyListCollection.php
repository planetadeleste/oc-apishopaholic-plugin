<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency
 */
class CurrencyListCollection extends CurrencyIndexCollection
{
    public $collects = CurrencyItemResource::class;
}
