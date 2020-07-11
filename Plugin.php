<?php namespace PlanetaDelEste\ApiShopaholic;

use Event;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ApiShopaholicHandle;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ExtendElementCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Property\ExtendPropertyCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\User\UserModelHandler;
use System\Classes\PluginBase;

/**
 * ApiShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    const EVENT_API_ORDER_RESPONSE_DATA = 'planetadeleste.apiShopaholic.apiOrderResponseData';
    const EVENT_API_GATEWAY_IPN_RESPONSE = 'planetadeleste.apiShopaholic.apiGatewayIpnResponse';
    const API_ROUTES = '/planetadeleste/apishopaholic/routes/';

    public $require = [
        'Lovata.OrdersShopaholic',
        'PlanetaDelEste.JWTAuth',
        'PlanetaDelEste.BuddiesGroup',
        'PlanetaDelEste.ApiToolbox'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'ApiShopaholic',
            'description' => 'No description provided yet...',
            'author'      => 'PlanetaDelEste',
            'icon'        => 'icon-leaf'
        ];
    }

    public function boot()
    {
        Event::subscribe(ExtendElementCollection::class);
        Event::subscribe(ExtendPropertyCollection::class);
        Event::subscribe(UserModelHandler::class);
        Event::subscribe(ApiShopaholicHandle::class);
    }
}
