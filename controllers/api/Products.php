<?php

namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\Shopaholic\Classes\Store\ProductListStore;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\IndexCollection as ProductIndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ItemResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiToolbox\Plugin;
use PlanetaDelEste\GW\Classes\Helper\ApiHelper;

class Products extends Base
{
    /**
     * @return void
     */
    public function init(): void
    {
        $this->bindEvent(
            Plugin::EVENT_LOCAL_BEFORE_SAVE,
            static function (Product $obModel, array &$arData): void {
                array_forget($arData, 'category');

                if (!array_get($arData, 'brand_id')) {
                    array_forget($arData, 'brand_id');
                }

                if (!array_get($arData, 'offers') || !$obModel->exists) {
                    return;
                }

                array_forget($arData, 'offers');
            }
        );

        $this->bindEvent(
            Plugin::EVENT_LOCAL_AFTER_SAVE,
            static function (Product $obModel, array $arData): void {
                if (!$arOffers = array_get($arData, 'offers')) {
                    return;
                }

                foreach ($arOffers as $arOffer) {
                    $iOfferID = array_get($arOffer, 'id', 0);
                    $obOffer  = Offer::findOrNew($iOfferID);
                    $obOffer->fill($arOffer);

                    if (!$iOfferID) {
                        $obModel->offer()->add($obOffer);
                    } else {
                        $obOffer->save();
                    }
                }
            }
        );
    }

    /**
     * @return void
     */
    public function extendIndex(): void
    {
        if (!$limit = input('filters.limit')) {
            return;
        }

        $this->collection->take($limit);
    }

    /**
     * @return array|LengthAwarePaginator|JsonResponse|ProductIndexCollection
     */
    public function index()
    {
        if (input('filters.response', 'full') === 'compact') {
            try {

                /**
                 * Extend collection results
                 */
                $this->fireSystemEvent(Plugin::EVENT_API_EXTEND_INDEX, [&$this->collection], false);
                $arItemListId = $this->collection->getIDList();

                if (empty($arItemListId) || !ApiHelper::companyID()) {
                    return [];
                }

                $arData = Product::query()->select(['id', 'active', 'category_id', 'code', 'name', 'slug'])
                                          ->whereIn('id', $arItemListId)
                                          ->get();
                $obResponse = ProductIndexCollection::make(ItemResource::collection($arData));
                $this->fireSystemEvent(Plugin::EVENT_API_AFTER_INDEX, [$obResponse], false);

                return $obResponse;
            } catch (Exception $e) {
                return static::exceptionResult($e);
            }
        }

        return parent::index();
    }

    /**
     * @param int $iProductID
     *
     * @return IndexCollection
     */
    public function offers(int $iProductID): IndexCollection
    {
        if ($this->isBackend()) {
            /** @var Product $obProduct */
            $obProduct         = Product::find($iProductID);
            $obOfferCollection = OfferCollection::make($obProduct->offer()->lists('id'))->collect();
        } else {
            /** @var ProductItem $obProductItem */
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
}
