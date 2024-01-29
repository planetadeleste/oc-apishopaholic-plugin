<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Event\PriceType;

use Backend\Widgets\Form;
use Lovata\Shopaholic\Controllers\PriceTypes;
use Lovata\Shopaholic\Models\PriceType;
use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

/**
 * Class ExtendPriceTypeFieldsHandler
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\PriceType
 */
class ExtendPriceTypeFieldsHandler extends AbstractBackendFieldHandler
{
    /**
     * Extend fields model
     *
     * @param Form $obWidget
     */
    protected function extendFields($obWidget): void
    {
        $this->removeField($obWidget);
        $this->addField($obWidget);
    }

    /**
     * Remove fields model
     *
     * @param Form $obWidget
     */
    protected function removeField($obWidget): void
    {
        $obWidget->removeField('');
    }

    /**
     * Add fields model
     *
     * @param Form $obWidget
     */
    protected function addField($obWidget): void
    {
        $obWidget->addTabFields([
            'currency' => [
                'label' => 'lovata.shopaholic::lang.field.currency',
                'span'  => 'left',
                'type'  => 'relation',
            ]
        ]);
    }

    /**
     * Get model class name
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return PriceType::class;
    }

    /**
     * Get controller class name
     *
     * @return string
     */
    protected function getControllerClass(): string
    {
        return PriceTypes::class;
    }
}
