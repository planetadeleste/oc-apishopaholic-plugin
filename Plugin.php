<?php namespace PlanetaDelEste\ApiShopaholic;

use Event;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ExtendElementCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Property\ExtendPropertyCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\User\UserModelHandler;
use System\Classes\PluginBase;

/**
 * ApiShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    const EVENT_SHOWRESOURCE_DATA = 'planetadeleste.apiShopaholic.showResourceData';
    const EVENT_ITEMRESOURCE_DATA = 'planetadeleste.apiShopaholic.itemResourceData';
    const EVENT_API_EXTEND_INDEX = 'planetadeleste.apiShopaholic.apiExtendIndex';
    const EVENT_API_EXTEND_LIST = 'planetadeleste.apiShopaholic.apiExtendList';
    const EVENT_API_EXTEND_SHOW = 'planetadeleste.apiShopaholic.apiExtendShow';
    const EVENT_API_BEFORE_SHOW_COLLECT = 'planetadeleste.apiShopaholic.apiBeforeShowCollect';
    const EVENT_API_EXTEND_STORE = 'planetadeleste.apiShopaholic.apiExtendStore';
    const EVENT_API_EXTEND_UPDATE = 'planetadeleste.apiShopaholic.apiExtendUpdate';
    const EVENT_API_EXTEND_DESTROY = 'planetadeleste.apiShopaholic.apiExtendDestroy';
    const EVENT_API_ADD_COLLECTION = 'planetadeleste.apiShopaholic.apiAddCollection';
    const EVENT_API_ORDER_RESPONSE_DATA = 'planetadeleste.apiShopaholic.apiOrderResponseData';
    const EVENT_API_GATEWAY_IPN_RESPONSE = 'planetadeleste.apiShopaholic.apiGatewayIpnResponse';
    const API_ROUTES = '/planetadeleste/apishopaholic/routes/';

    public $require = [
        'Lovata.OrdersShopaholic',
        'PlanetaDelEste.JWTAuth',
        'PlanetaDelEste.BuddiesGroup'
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
    }
}
