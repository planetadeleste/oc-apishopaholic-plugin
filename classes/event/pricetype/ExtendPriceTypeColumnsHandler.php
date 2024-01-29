<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Event\PriceType;

use Backend\Widgets\Lists;
use Lovata\Shopaholic\Controllers\PriceTypes;
use Lovata\Shopaholic\Models\PriceType;
use Lovata\Toolbox\Classes\Event\AbstractBackendColumnHandler;

/**
 * Class ExtendPriceTypeColumnsHandler
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\PriceType
 */
class ExtendPriceTypeColumnsHandler extends AbstractBackendColumnHandler
{
    /**
     * Extend columns model
     *
     * @param Lists $obWidget
     */
    protected function extendColumns($obWidget): void
    {
        $this->removeColumn($obWidget);
        $this->addColumn($obWidget);
    }

    /**
     * Remove columns model
     *
     * @param Lists $obWidget
     */
    protected function removeColumn($obWidget): void
    {
        $obWidget->removeColumn('');
    }

    /**
     * Add columns model
     *
     * @param Lists $obWidget
     */
    protected function addColumn($obWidget): void
    {
        $obWidget->addColumns([
            'currency' => [
                'label'     => 'lovata.shopaholic::lang.field.currency',
                'relation'  => 'currency',
                'valueFrom' => 'name',
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
