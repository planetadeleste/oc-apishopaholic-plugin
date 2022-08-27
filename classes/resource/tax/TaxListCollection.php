<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax;

/**
 * Class ListCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Tax
 */
class TaxListCollection extends TaxIndexCollection
{
    public $collects = TaxItemResource::class;
}
