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

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ListCollection;
use PlanetaDelEste\ApiToolbox\Plugin;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\GroupCollection;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\UserCollection;
use System\Classes\PluginManager;

class ApiShopaholicHandle
{
    /**
     * @param \October\Rain\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen(
            Plugin::EVENT_ITEMRESOURCE_DATA,
            function ($arData, $obItemResource) {
                return $this->onExtendItem($arData, $obItemResource);
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
     * @param \PlanetaDelEste\ApiToolbox\Classes\Resource\Base $obItemResource
     *
     * @return array
     */
    protected function onExtendItem($arData, $obItemResource)
    {
        if ($obItemResource instanceof ItemResourceCategory) {
            if (input('filters.tree')) {
                return [
                    'children' => empty($obItemResource->children_id_list)
                        ? []
                        : ListCollection::make($obItemResource->children->collect())
                ];
            }
        }

        return null;
    }

    protected function addCollections()
    {
        // Main Shopaholic collections
        $arCollectionClasses = [
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

        if (PluginManager::instance()->hasPlugin('Lovata.OrdersShopaholic')) {
            // OrderShopaholic plugin collections
            $arCollectionClasses += [
                \Lovata\OrdersShopaholic\Models\CartPosition::class  => \Lovata\OrdersShopaholic\Classes\Collection\CartPositionCollection::class,
                \Lovata\OrdersShopaholic\Models\Order::class         => \Lovata\OrdersShopaholic\Classes\Collection\OrderCollection::class,
                \Lovata\OrdersShopaholic\Models\OrderPosition::class => \Lovata\OrdersShopaholic\Classes\Collection\OrderPositionCollection::class,
                \Lovata\OrdersShopaholic\Models\PaymentMethod::class => \Lovata\OrdersShopaholic\Classes\Collection\PaymentMethodCollection::class,
            ];
        }

        return $arCollectionClasses;
    }
}
