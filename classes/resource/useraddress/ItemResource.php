<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiToolbox\Plugin;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;
use VojtaSvoboda\LocationTown\Models\Town;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\UserAddressItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\UserAddress
 */
class ItemResource extends BaseResource
{
    /**
     * @return array|void
     */
    public function getData()
    {
        /** @var Country $obCountry */
        $obCountry = is_numeric($this->country) ? Country::find($this->country) : null;
        if (!$obCountry) {
            $obCountry = Country::getDefault();
        }

        /** @var State $obState */
        $obState = is_numeric($this->state) ? State::find($this->state) : null;

        /** @var Town $obCity */
        $obCity = is_numeric($this->city) ? Town::find($this->city) : null;

        return [
            'country_text' => $obCountry ? $obCountry->name : $this->country,
            'state_text'   => $obState ? $obState->name : $this->state,
            'city_text'    => $obCity ? $obCity->name : $this->city,
            'country'      => is_numeric($this->country) ? intval($this->country) : $this->country,
            'state'        => is_numeric($this->state) ? intval($this->state) : $this->state,
            'city'         => is_numeric($this->city) ? intval($this->city) : $this->city,
        ];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'user_id',
            'type',
            'country',
            'state',
            'city',
            'country_text',
            'state_text',
            'city_text',
            'street',
            'house',
            'building',
            'flat',
            'floor',
            'address1',
            'address2',
            'postcode',
            'created_at',
            'updated_at'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
