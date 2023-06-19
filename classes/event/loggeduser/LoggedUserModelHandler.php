<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\LoggedUser;

use Lovata\Toolbox\Classes\Event\ModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Store\UserListStore;
use PlanetaDelEste\ApiShopaholic\Models\LoggedUser;
use PlanetaDelEste\ApiShopaholic\Classes\Item\LoggedUserItem;
use PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUserListStore;

/**
 * Class LoggedUserModelHandler
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\LoggedUser
 */
class LoggedUserModelHandler extends ModelHandler
{
    /** @var LoggedUser */
    protected $obElement;

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass(): string
    {
        return LoggedUser::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass(): string
    {
        return LoggedUserItem::class;
    }
    /**
     * After create event handler
     */
    protected function afterCreate()
    {
        parent::afterCreate();

        $this->clearBySortingPublished();
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();
        UserListStore::instance()->logged->clear();
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        $this->clearBySortingPublished();
    }

    /**
     * Clear cache by created_at
     */
    protected function clearBySortingPublished()
    {
        LoggedUserListStore::instance()->sorting->clear(LoggedUserListStore::SORT_CREATED_AT_ASC);
        LoggedUserListStore::instance()->sorting->clear(LoggedUserListStore::SORT_CREATED_AT_DESC);
    }
}
