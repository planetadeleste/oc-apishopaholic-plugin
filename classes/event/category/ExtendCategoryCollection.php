<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Category;

use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Store\CategoryListStore;

class ExtendCategoryCollection
{
    public function subscribe()
    {
        CategoryCollection::extend(
            function ($obCollection) {
                $this->extendCollection($obCollection);
            }
        );
    }

    /**
     * @param CategoryCollection $obCollection
     */
    protected function extendCollection($obCollection)
    {
        $obCollection->addDynamicMethod('sort', function($sSort = CategoryListStore::SORT_CREATED_AT_ASC) use ($obCollection) {
            $arResultIDList = CategoryListStore::instance()->sorting->get($sSort);
            debug($arResultIDList);
            return $obCollection->intersect($arResultIDList);
        });
    }
}
