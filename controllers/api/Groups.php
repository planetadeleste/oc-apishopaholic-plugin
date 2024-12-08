<?php

namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\Group;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Group\GroupIndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Group\GroupListCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Group\GroupShowResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\GroupCollection;
use PlanetaDelEste\BuddiesGroup\Classes\Store\GroupListStore;

/**
 * Class Groups
 *
 * @property GroupCollection $collection
 */
class Groups extends Base
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Group::class;
    }

    /**
     * @return string
     */
    public function getSortColumn(): string
    {
        return GroupListStore::SORT_NAME_ASC;
    }

    /**
     * @return string|null
     */
    public function getIndexResource(): ?string
    {
        return GroupIndexCollection::class;
    }

    /**
     * @return string|null
     */
    public function getListResource(): ?string
    {
        return GroupListCollection::class;
    }

    /**
     * @return string|null
     */
    public function getShowResource(): ?string
    {
        return GroupShowResource::class;
    }
}
