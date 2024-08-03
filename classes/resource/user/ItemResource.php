<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\User;

use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Models\User;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;

/**
 * Class ItemResource
 *
 * @mixin UserItem
 * @mixin User
 */
class ItemResource extends BaseResource
{
    /**
     * @var array<string>
     */
    public array $arDates = ['created_at', 'updated_at', 'last_login', 'last_activity_at'];

    /**
     * @var array<string>
     */
    protected $casts = [
        'is_superuser' => 'boolean',
        'is_activated' => 'boolean',
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'avatar'     => $this->avatar?->getPath(),
            'groups'     => $this->groups ? $this->groups->lists('code') : [],
            'property'   => empty($this->property) ? [] : $this->property,
            'phone_list' => empty($this->phone_list) ? [] : array_wrap($this->phone_list),
        ];
    }

    /**
     * @return array<string>
     */
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
            'is_superuser',
            'last_activity_at',
        ];
    }

    protected function getEvent(): string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.user';
    }
}
