<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Tax;

use Lovata\Shopaholic\Classes\Item\TaxItem;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\Shopaholic\Models\Tax;

/**
 * Class TaxModelHandler
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\Tax
 */
class TaxModelHandler extends ModelHandler
{
    /** @var Tax */
    protected $obElement;

    public function subscribe($obEvent): void
    {
        parent::subscribe($obEvent);

        Tax::extend(
            function ($obModel) {
                $this->extendModel($obModel);
            }
        );
    }

    protected function extendModel(Tax $obModel): void
    {
        $obModel->addCachedField(['active', 'sort_order']);
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass(): string
    {
        return Tax::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass(): string
    {
        return TaxItem::class;
    }
}
