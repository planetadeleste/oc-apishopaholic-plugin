<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cms\Classes\ComponentManager;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Classes\Item\ShippingTypeItem;
use Lovata\OrdersShopaholic\Components\Cart as CartComponent;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\ShowResource as ShowResourceOffer;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Product\ItemResource as ItemResourceProduct;

class Cart extends Base
{
    /**
     * @return array
     * @throws \SystemException
     */
    public function getData()
    {
        return $this->component()->onGetData();
    }

    /**
     * @return array
     * @throws \SystemException
     * @throws \Exception
     */
    public function add()
    {
        $response = $this->component()->onAdd();
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
    public function update($id)
    {
        return $this->component()->onUpdate();
    }

    /**
     * @return array|\Lovata\Toolbox\Classes\Item\ElementItem[]
     * @throws \SystemException
     */
    public function remove()
    {
        $response = $this->component()->onRemove();
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
        $obCartPositionCollection = $this->component()->get($obShippingTypeItem);
        $arCartData = [];
        if ($obCartPositionCollection->isNotEmpty()) {
            $arCartDataPositions = [];
            foreach ($obCartPositionCollection as $obCartPositionItem) {
                /** @var \Lovata\OrdersShopaholic\Classes\Item\CartPositionItem $obCartPositionItem */
                /** @var \Lovata\Shopaholic\Models\Offer $obOfferModel */

                $obOffer = $obCartPositionItem->offer;
                $obOfferModel = $obOffer->getObject();
                $arCartDataPositions[] = [
                    'offer'       => ShowResourceOffer::make($obOfferModel),
                    'product'     => ItemResourceProduct::make($obOfferModel->product),
                    'price'       => $obOffer->price,
                    'currency'    => $obOffer->currency,
                    'total'       => $obCartPositionItem->price,
                    'total_value' => $obCartPositionItem->price_value,
                    'quantity'    => $obCartPositionItem->quantity,
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
     * @throws \Exception
     */
    protected function component()
    {
        $component = ComponentManager::instance()->makeComponent(CartComponent::class);
        if (!$component) {
            throw new \Exception('cart component not found');
        }

        return $component;
    }
}
