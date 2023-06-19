<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Collection;

use Lovata\Toolbox\Classes\Collection\ElementCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Item\LoggedUserItem;
use PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUserListStore;

/**
 * Class LoggedUserCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Collection
 */
class LoggedUserCollection extends ElementCollection
{
    public const ITEM_CLASS = LoggedUserItem::class;

    /**
     * Sort list by
     *
     * @param string $sSorting
     * @return $this
     */
    public function sort(string $sSorting = 'last_activity_at|desc'): self
    {
        $arResultIDList = LoggedUserListStore::instance()->sorting->get($sSorting);

        return $this->applySorting($arResultIDList);
    }

    /**
     * @return $this
     */
    public function logged(): self
    {
        $arResultIDList = LoggedUserListStore::instance()->logged->get();

        return $this->intersect($arResultIDList);
    }
}
