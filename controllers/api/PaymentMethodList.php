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
        /** @var PaymentMethodListComponent $obPaymentListComponent */
        $obPaymentListComponent = $this->component(PaymentMethodListComponent::class);
        $obPaymentMethodList = $obPaymentListComponent->make()->sort()->active();

        return Result::setData($obPaymentMethodList->toArray())->get();
    }
}
