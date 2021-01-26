<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Brand;

use Lovata\Shopaholic\Classes\Item\BrandItem;
use Lovata\Shopaholic\Classes\Store\BrandListStore;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\Shopaholic\Models\Brand;

/**
 * Class BrandModelHandler
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\Brand
 */
class BrandModelHandler extends ModelHandler
{
    /** @var Brand */
    protected $obElement;

    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Brand::extend(
            function ($obModel) {
                $this->extendModel($obModel);
            }
        );
    }

    protected function extendModel(Brand $obModel)
    {
        $obModel->addCachedField(['active', 'external_id']);
    }

    /**
     * Get model class name
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Brand::class;
    }

    /**
     * Get item class name
     *
     * @return string
     */
    protected function getItemClass(): string
    {
        return BrandItem::class;
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();

        $this->checkFieldChanges('active', BrandListStore::instance()->active);
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        if ($this->obElement->active) {
            BrandListStore::instance()->active->clear();
        }
    }
}
