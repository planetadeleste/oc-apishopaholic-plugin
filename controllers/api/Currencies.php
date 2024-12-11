<?php

namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Models\Currency;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency\CurrencyIndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency\CurrencyListCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Currency\CurrencyShowResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Currencies
 */
class Currencies extends Base
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Currency::class;
    }

    /**
     * @return string
     */
    public function getSortColumn(): string
    {
        return 'sort_order|asc';
    }

    /**
     * @return string|null
     */
    public function getIndexResource(): ?string
    {
        return CurrencyIndexCollection::class;
    }

    /**
     * @return string|null
     */
    public function getListResource(): ?string
    {
        return CurrencyListCollection::class;
    }

    /**
     * @return string|null
     */
    public function getShowResource(): ?string
    {
        return CurrencyShowResource::class;
    }
}
