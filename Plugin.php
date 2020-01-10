<?php namespace PlanetaDelEste\ApiShopaholic;

use Backend;
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
    const EVENT_API_EXTEND_STORE = 'planetadeleste.apiShopaholic.apiExtendStore';
    const EVENT_API_EXTEND_UPDATE = 'planetadeleste.apiShopaholic.apiExtendUpdate';
    const EVENT_API_EXTEND_DESTROY = 'planetadeleste.apiShopaholic.apiExtendDestroy';

    public $require = [
        'Lovata.OrdersShopaholic',
        //'Vdomah.JWTAuth'
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
}
