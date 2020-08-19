<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\User;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress\IndexCollection;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Buddies\Classes\Item\UserItem
 * @mixin \Lovata\Buddies\Models\User
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\User
 */
class ItemResource extends BaseResource
{
    public function getData()
    {
        return [
            'avatar'  => $this->avatar ? $this->avatar->getPath() : null,
            'groups'  => $this->groups ? $this->groups->lists('code') : [],
            'address' => $this->address ? IndexCollection::make(collect($this->address)) : []
        ];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'email',
            'name',
            'last_name',
            'middle_name',
            'phone',
            'phone_list',
            'property',
            'avatar',
            'groups',
            'address',
            'is_activated'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
