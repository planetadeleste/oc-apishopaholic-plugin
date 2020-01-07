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
