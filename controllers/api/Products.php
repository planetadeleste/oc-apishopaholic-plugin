<?php

namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Store\ProductListStore;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ProductIndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ProductListCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ProductShowResource;
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

                //                if (array_get($arData, 'offers') && $obModel->exists) {
                //                    array_forget($arData, 'offers');
                //                }
            }
        );

        $this->bindEvent(
            Plugin::EVENT_LOCAL_AFTER_SAVE,
            function (Product $obModel, array $arData) {
                $arOldOfferIdList = $obModel->offer()->lists('id');
                $arNewOfferIdList = [];

                if ($arOffers = array_get($arData, 'offers')) {
                    foreach ($arOffers as $arOffer) {
                        $iOfferID = array_get($arOffer, 'id', 0);
                        $obOffer  = Offer::findOrNew($iOfferID);
                        $obOffer->fill($arOffer);
                        if (!$iOfferID) {
                            $obModel->offer()->add($obOffer);
                        } else {
                            $obOffer->save();
                        }

                        $arNewOfferIdList[] = $obOffer->id;
                    }
                }

                if (!empty($arOldOfferIdList)) {
                    $arDeleteOfferIdList = array_diff($arOldOfferIdList, $arNewOfferIdList);
                    foreach ($arDeleteOfferIdList as $iOfferID) {
                        $obModel->offer()->find($iOfferID)->delete();
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
            $obProduct         = Product::find($iProductID);
            $obOfferCollection = OfferCollection::make($obProduct->offer()->lists('id'))->collect();
        } else {
            /** @var \Lovata\Shopaholic\Classes\Item\ProductItem $obProductItem */
            $obProductItem     = $this->getItem($iProductID);
            $obOfferCollection = $obProductItem->offer->collect();
        }

        return IndexCollection::make($obOfferCollection);
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Product::class;
    }

    /**
     * @return string
     */
    public function getSortColumn(): string
    {
        return ProductListStore::SORT_NEW;
    }

    /**
     * @return string|null
     */
    public function getIndexResource(): ?string
    {
        return ProductIndexCollection::class;
    }

    /**
     * @return string|null
     */
    public function getShowResource(): ?string
    {
        return ProductShowResource::class;
    }

    /**
     * @return string|null
     */
    public function getListResource(): ?string
    {
        return ProductListCollection::class;
    }
}
