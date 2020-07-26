<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Category;

use Lovata\Shopaholic\Classes\Item\CategoryItem;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\Shopaholic\Models\Category;
use PlanetaDelEste\ApiShopaholic\Classes\Store\CategoryListStore;

/**
 * Class CategoryModelHandler
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\Category
 */
class CategoryModelHandler extends ModelHandler
{
    /** @var Category */
    protected $obElement;

    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);
        Category::extend(function ($obModel){
            $this->extendModel($obModel);
        });
    }

    /**
     * @param Category $obModel
     */
    protected function extendModel($obModel)
    {
        $obModel->casts['active'] = 'boolean';
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Category::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return CategoryItem::class;
    }
    /**
     * After create event handler
     */
    protected function afterCreate()
    {
        parent::afterCreate();
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();
        $this->clearStoreCache();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        $this->clearStoreCache();
    }

    protected function clearStoreCache()
    {
        CategoryListStore::instance()->sorting->clear(CategoryListStore::SORT_CREATED_AT_ASC);
        CategoryListStore::instance()->sorting->clear(CategoryListStore::SORT_CREATED_AT_DESC);
    }
}
