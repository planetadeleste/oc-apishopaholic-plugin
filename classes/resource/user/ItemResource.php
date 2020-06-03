<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\User;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;
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
    public function getData()
    {
        return [
            'id'              => $this->id,
            'email'           => $this->email,
            'name'            => $this->name,
            'last_name'       => $this->last_name,
            'middle_name'     => $this->middle_name,
            'phone'           => $this->phone,
            'phone_list'      => $this->phone_list,
            'socialite_token' => $this->socialite_token,
            'avatar'          => $this->avatar ? $this->avatar->getPath() : null,
            'property'        => $this->property,
            'groups'          => $this->groups()->count() ? $this->groups()->lists('code') : []
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
