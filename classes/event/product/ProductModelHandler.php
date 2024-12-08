<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Product;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\Shopaholic\Models\Product;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Store\ProductListStore;
use PlanetaDelEste\ApiToolbox\Traits\Event\ModelHandlerTrait;

/**
 * Class ProductModelHandler
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\Product
 */
class ProductModelHandler extends ModelHandler
{
    use ModelHandlerTrait;

    /**
     * @var Product
     */
    protected $obElement;

    public function subscribe($obEvent): void
    {
        parent::subscribe($obEvent);

        ProductCollection::extend(
            function ($obCollection): void {
                $this->extendCollection($obCollection);
            }
        );
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass(): string
    {
        return Product::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass(): string
    {
        return ProductItem::class;
    }

    /**
     * After create event handler
     */
    protected function afterCreate(): void
    {
        parent::afterCreate();
        $this->clearCache();
    }

    /**
     * After save event handler
     */
    protected function afterSave(): void
    {
        parent::afterSave();
        $this->clearCache();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete(): void
    {
        parent::afterDelete();
        $this->clearCache();
    }

    /**
     * @return void
     */
    protected function clearCache(): void
    {
        $this->clearCacheFields(['slug']);
    }

    /**
     * @param ProductCollection $obCollection
     *
     * @return void
     */
    protected function extendCollection(ProductCollection $obCollection): void
    {
        $obCollection->addDynamicMethod('slug', static function (string $sValue) use ($obCollection) {
            $arResultIdList = ProductListStore::instance()->slug->get($sValue);

            return $obCollection->intersect($arResultIdList);
        });
    }

    protected function getStoreClass(): string
    {
        return ProductListStore::class;
    }
}
