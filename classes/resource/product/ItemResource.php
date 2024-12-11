<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Lovata\Shopaholic\Classes\Item\ProductItem;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand\BrandItemResource as ItemResourceBrand;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection as IndexCollectionOffer;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use System\Classes\PluginManager;

/**
 * Class ItemResource
 *
 * @mixin ProductItem
 *
 * @deprecated Use ProductItemResource instead
 */
class ItemResource extends ProductItemResource
{
}
