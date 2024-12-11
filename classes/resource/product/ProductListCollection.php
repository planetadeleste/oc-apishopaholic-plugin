<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

/**
 * Class ListCollection
 */
class ProductListCollection extends ProductIndexCollection
{
    public $collects = ProductItemResource::class;
}
