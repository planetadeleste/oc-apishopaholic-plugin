<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Store\Category;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithParam;
use Lovata\Shopaholic\Models\Category;
use PlanetaDelEste\ApiShopaholic\Classes\Store\CategoryListStore;

/**
 * Class SortingListStore
 * @package PlanetaDelEste\ApiShopaholic\Classes\Store\Category
 */
class SortingListStore extends AbstractStoreWithParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        switch ($this->sValue) {
            case CategoryListStore::SORT_CREATED_AT_ASC:
                $arElementIDList = $this->getByPublishASC();
                break;
            case CategoryListStore::SORT_CREATED_AT_DESC:
                $arElementIDList = $this->getByPublishDESC();
                break;
            default:
                $arElementIDList = $this->getDefaultList();
                break;
        }

        return $arElementIDList;
    }

    /**
     * Get default list
     * @return array
     */
    protected function getDefaultList() : array
    {
        $arElementIDList = (array) Category::lists('id');

        return $arElementIDList;
    }

    /**
     * Get sorting ID list by published (ASC)
     * @return array
     */
    protected function getByPublishASC() : array
    {
        $arElementIDList = (array) Category::orderBy('created_at', 'asc')->lists('id');

        return $arElementIDList;
    }

    /**
     * Get sorting ID list by published (DESC)
     * @return array
     */
    protected function getByPublishDESC() : array
    {
        $arElementIDList = (array) Category::orderBy('created_at', 'desc')->lists('id');

        return $arElementIDList;
    }
}
