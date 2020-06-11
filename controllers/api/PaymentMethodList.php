<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cms\Classes\ComponentManager;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Components\PaymentMethodList as PaymentMethodListComponent;

class PaymentMethodList extends Base
{
    /**
     * @return array
     * @throws \SystemException
     */
    public function get()
    {
        $obPaymentMethodList = $this->component()->make()->sort()->active();

        return Result::setData($obPaymentMethodList->toArray())->get();
    }
    /**
     * @return PaymentMethodListComponent
     * @throws \SystemException
     * @throws \Exception
     */
    protected function component()
    {
        /** @var PaymentMethodListComponent $component */
        $component = ComponentManager::instance()->makeComponent(PaymentMethodListComponent::class);
        if (!$component) {
            throw new \Exception('cart component not found');
        }

        return $component;
    }
}
