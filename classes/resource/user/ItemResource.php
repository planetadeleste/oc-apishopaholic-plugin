<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\User;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Buddies\Classes\Item\UserItem
 * @mixin \Lovata\Buddies\Models\User
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\User
 */
class ItemResource extends BaseResource
{
    public array $arDates = ['created_at', 'updated_at', 'last_login', 'last_activity_at'];

    public function getData(): array
    {
        return [
            'avatar'   => $this->avatar ? $this->avatar->getPath() : null,
            'groups'   => $this->groups ? $this->groups->lists('code') : [],
            'property' => empty($this->property) ? [] : $this->property,
        ];
    }

    public function getDataKeys(): array
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
            'role',
            'address',
            'is_activated',
            'last_activity_at',
        ];
    }

    protected function getEvent(): string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA . '.user';
    }
}
