<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Event;
use Exception;
use Illuminate\Http\JsonResponse;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Components\MakeOrder;
use Lovata\OrdersShopaholic\Models\Order;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Order\IndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Order\ListCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Order\ShowResource;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Orders
 *
 * @property \Lovata\OrdersShopaholic\Classes\Collection\OrderCollection $collection
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Orders extends Base
{
    public $primaryKey = 'secret_key';
    public function extendIndex(): JsonResponse
    {
        try {
            $this->currentUser();
            $this->collection->user($this->user->id);
        } catch (Exception $e) {
            Result::setFalse()->setMessage($e->getMessage());
            return response()->json(Result::get(), 403);
        }
    }

    /**
     * @return array|\Illuminate\Http\RedirectResponse
     * @throws \SystemException
     * @throws \Exception
     */
    public function create()
    {
        /** @var MakeOrder $obComponent */
        $obComponent = $this->component(MakeOrder::class);
        $obComponent->onCreate();
        $arResponseData = Event::fire(Plugin::EVENT_API_ORDER_RESPONSE_DATA, [Result::data()]);

        if (!empty($arResponseData)) {
            $arResultData = Result::data();
            foreach ($arResponseData as $arData) {
                if (empty($arData) || !is_array($arData)) {
                    continue;
                }
                $arResultData = array_merge($arResultData, $arData);
            }

            Result::setData($arResultData);
        }

        return Result::get();
    }

    public function ipn()
    {
        Event::fire(Plugin::EVENT_API_GATEWAY_IPN_RESPONSE, input());
    }

    public function getModelClass(): string
    {
        return Order::class;
    }

    public function getIndexResource(): string
    {
        return IndexCollection::class;
    }

    public function getListResource(): string
    {
        return ListCollection::class;
    }

    public function getShowResource(): string
    {
        return ShowResource::class;
    }
}
