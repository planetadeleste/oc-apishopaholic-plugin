<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Store\ProductListStore;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiToolbox\Plugin;

class Products extends Base
{
    public function init(): void
    {
        $this->bindEvent(
            Plugin::EVENT_LOCAL_BEFORE_SAVE,
            function (Product $obModel, array &$arData) {
                array_forget($arData, 'category');
                if (!array_get($arData, 'brand_id')) {
                    array_forget($arData, 'brand_id');
                }

                if (array_get($arData, 'offers') && $obModel->exists) {
                    array_forget($arData, 'offers');
                }
            }
        );

        $this->bindEvent(
            Plugin::EVENT_LOCAL_AFTER_SAVE,
            function (Product $obModel, array $arData) {
                if ($arOffers = array_get($arData, 'offers')) {
                    foreach ($arOffers as $arOffer) {
                        $iOfferID = array_get($arOffer, 'id', 0);
                        $obOffer = Offer::findOrNew($iOfferID);
                        $obOffer->fill($arOffer);
                        if (!$iOfferID) {
                            $obModel->offer()->add($obOffer);
                        } else {
                            $obOffer->save();
                        }
                    }
                }
            }
        );
    }

    public function extendIndex()
    {
        if ($limit = input('filters.limit')) {
            $this->collection->take($limit);
        }
    }

    /**
     * @param int $iProductID
     *
     * @return \PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection
     */
    public function offers(int $iProductID): IndexCollection
    {
        if ($this->isBackend()) {
            /** @var Product $obProduct */
            $obProduct = Product::find($iProductID);
            $obOfferCollection = OfferCollection::make($obProduct->offer()->lists('id'))->collect();
        } else {
            /** @var \Lovata\Shopaholic\Classes\Item\ProductItem $obProductItem */
            $obProductItem = $this->getItem($iProductID);
            $obOfferCollection = $obProductItem->offer->collect();
        }

        return IndexCollection::make($obOfferCollection);
    }

    public function getModelClass(): string
    {
        return Product::class;
    }

    public function getSortColumn(): string
    {
        return ProductListStore::SORT_NEW;
    }
}
