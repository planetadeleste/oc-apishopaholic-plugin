<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cms\Classes\ComponentManager;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Classes\Item\ShippingTypeItem;
use Lovata\OrdersShopaholic\Components\Cart as CartComponent;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\ShowResource as ShowResourceOffer;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ItemResource as ItemResourceProduct;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

class Cart extends Base
{
    /**
     * @return array
     * @throws \SystemException
     */
    public function getData()
    {
        return $this->cartComponent()->onGetCartData();
    }

    /**
     * @return array
     * @throws \SystemException
     * @throws \Exception
     */
    public function add()
    {
        $response = $this->cartComponent()->onAdd();
        if (!input('return_data')) {
            return $this->get();
        }

        return $response;
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \SystemException
     */
    public function update($id = null)
    {
        $response = $this->cartComponent()->onUpdate();
        if (!input('return_data')) {
            return $this->get();
        }

        return $response;
    }

    /**
     * @return array|\Lovata\Toolbox\Classes\Item\ElementItem[]
     * @throws \SystemException
     */
    public function remove()
    {
        $response = $this->cartComponent()->onRemove();
        if (!input('return_data')) {
            return $this->get();
        }

        return $response;
    }

    /**
     * @param int|null $iShippingTypeId
     *
     * @return array|\Lovata\Toolbox\Classes\Item\ElementItem[]
     * @throws \SystemException
     * @throws \Exception
     */
    public function get($iShippingTypeId = null)
    {
        $obShippingTypeItem = $iShippingTypeId ? ShippingTypeItem::make($iShippingTypeId) : null;
        $obCartPositionCollection = $this->cartComponent()->get($obShippingTypeItem);
        $arCartData = [];
        if ($obCartPositionCollection->isNotEmpty()) {
            $arCartDataPositions = [];
            foreach ($obCartPositionCollection as $obCartPositionItem) {
                /** @var \Lovata\OrdersShopaholic\Classes\Item\CartPositionItem $obCartPositionItem */
                /** @var \Lovata\Shopaholic\Models\Offer $obOfferModel */

                $obOffer = $obCartPositionItem->offer;
//                $obOfferModel = $obOffer->getObject();
                $arCartDataPositions[] = [
                    'offer'                => ShowResourceOffer::make($obOffer),
                    'product'              => ItemResourceProduct::make($obOffer->product),
                    'price'                => $obOffer->price,
                    'currency'             => $obOffer->currency,
                    'total'                => $obCartPositionItem->price,
                    'total_value'          => $obCartPositionItem->price_value,
                    'quantity'             => $obCartPositionItem->quantity,
                    'price_per_unit'       => $obCartPositionItem->price_per_unit,
                    'price_per_unit_value' => $obCartPositionItem->price_per_unit_value,
                ];
            }

            $arCartData = [
                'positions'   => $arCartDataPositions,
                'currency'    => $obCartPositionCollection->getCurrency(),
                'total'       => $obCartPositionCollection->getTotalPrice(),
                'total_value' => $obCartPositionCollection->getTotalPriceValue(),
            ];
        }

        return Result::setData($arCartData)->get();
    }

    /**
     * @return \Cms\Classes\ComponentBase|\Lovata\OrdersShopaholic\Components\Cart
     * @throws \SystemException
     */
    protected function cartComponent()
    {
        return $this->component(CartComponent::class);
    }
}
