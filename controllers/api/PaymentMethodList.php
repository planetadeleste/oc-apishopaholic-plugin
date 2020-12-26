<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cms\Classes\ComponentManager;
use Kharanenka\Helper\Result;
use Lovata\OrdersShopaholic\Components\PaymentMethodList as PaymentMethodListComponent;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

class PaymentMethodList extends Base
{
    /**
     * @return array
     * @throws \SystemException
     */
    public function get(): array
    {
        /** @var PaymentMethodListComponent $obPaymentListComponent */
        $obPaymentListComponent = $this->component(PaymentMethodListComponent::class);
        $obPaymentMethodList = $obPaymentListComponent->make()->sort()->active();

        return Result::setData($obPaymentMethodList->toArray())->get();
    }
}
