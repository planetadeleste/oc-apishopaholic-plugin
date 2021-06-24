<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Category;

use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use Lovata\Shopaholic\Classes\Item\CategoryItem;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\Shopaholic\Models\Category;
use PlanetaDelEste\ApiShopaholic\Classes\Store\CategoryListStore;

/**
 * Class CategoryModelHandler
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\Category
 */
class CategoryModelHandler extends ModelHandler
{
    /** @var Category */
    protected $obElement;

    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Category::extend(
            function ($obModel) {
                $this->extendModel($obModel);
            }
        );

        CategoryCollection::extend(
            function ($obCollection) {
                $this->extendCollection($obCollection);
            }
        );
    }

    /**
     * @param Category $obModel
     */
    protected function extendModel($obModel)
    {
        $obModel->casts['active'] = 'boolean';
        $obModel->addCachedField('active');
    }

    /**
     * @param CategoryCollection $obCollection
     */
    protected function extendCollection($obCollection)
    {
        $obCollection->addDynamicMethod(
            'sort',
            function ($sSort = CategoryListStore::SORT_CREATED_AT_ASC) use ($obCollection) {
                $arResultIDList = CategoryListStore::instance()->sorting->get($sSort);
                return $obCollection->applySorting($arResultIDList);
            }
        );

        $obCollection->addDynamicMethod(
            'root',
            function () use ($obCollection) {
                $arResultIDList = CategoryListStore::instance()->root->get();
                return $obCollection->applySorting($arResultIDList);
            }
        );
    }

    /**
     * Get model class name
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Category::class;
    }

    /**
     * Get item class name
     *
     * @return string
     */
    protected function getItemClass(): string
    {
        return CategoryItem::class;
    }

    /**
     * After create event handler
     */
    protected function afterCreate()
    {
        parent::afterCreate();
        $this->clearItemCache();
        $this->clearCache();
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();
        $this->clearCache();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        $this->clearCache();
    }

    protected function clearCache()
    {
//        !TODO: Find a better way to clear cache on all categories and now only current level
        \Artisan::call('cache:clear');
//        CategoryListStore::instance()->sorting->clear(CategoryListStore::SORT_CREATED_AT_ASC);
//        CategoryListStore::instance()->sorting->clear(CategoryListStore::SORT_CREATED_AT_DESC);
//        CategoryListStore::instance()->root->clear();
//        \Lovata\Shopaholic\Classes\Store\CategoryListStore::instance()->active->clear();
//        \Lovata\Shopaholic\Classes\Store\CategoryListStore::instance()->top_level->clear();
    }
}
