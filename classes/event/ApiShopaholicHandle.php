<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event;

use Lovata\Buddies\Models\Group;
use Lovata\Buddies\Models\User;
use Lovata\Shopaholic\Classes\Collection\BrandCollection;
use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use Lovata\Shopaholic\Classes\Collection\CurrencyCollection;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Classes\Collection\PromoBlockCollection;
use Lovata\Shopaholic\Classes\Collection\TaxCollection;
use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Currency;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\PromoBlock;
use Lovata\Shopaholic\Models\Tax;

use October\Rain\Events\Dispatcher;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ListCollection;
use PlanetaDelEste\ApiShopaholic\Plugin as PluginApiShopaholic;
use PlanetaDelEste\ApiToolbox\Plugin;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\GroupCollection;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\UserCollection;

class ApiShopaholicHandle
{
    /**
     * @param Dispatcher $obEvent
     */
    public function subscribe(Dispatcher $obEvent)
    {
        $obEvent->listen(
            PluginApiShopaholic::EVENT_ITEMRESOURCE_DATA.'.category',
            function ($obItemResource, $arData) {
                return $this->onExtendItem($obItemResource, $arData);
            }
        );

        $obEvent->listen(
            Plugin::EVENT_API_ADD_COLLECTION,
            function () {
                return $this->addCollections();
            }
        );
    }

    /**
     * @param array                                            $arData
     * @param ItemResourceCategory $obItemResource
     *
     * @return array
     */
    protected function onExtendItem(ItemResourceCategory $obItemResource, array $arData): ?array
    {
        if (input('filters.tree')) {
            return [
                'children' => empty($obItemResource->children_id_list)
                    ? []
                    : ListCollection::make($obItemResource->children->collect())
            ];
        }

        return null;
    }

    protected function addCollections(): array
    {
        // Main Shopaholic collections
        return [
            Brand::class      => BrandCollection::class,
            Category::class   => CategoryCollection::class,
            Currency::class   => CurrencyCollection::class,
            Offer::class      => OfferCollection::class,
            Product::class    => ProductCollection::class,
            PromoBlock::class => PromoBlockCollection::class,
            Tax::class        => TaxCollection::class,
            User::class       => UserCollection::class,
            Group::class      => GroupCollection::class
        ];
    }
}
