<?php namespace PlanetaDelEste\ApiShopaholic;

use Event;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ApiShopaholicHandle;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Brand\BrandModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Category\CategoryModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ExtendElementCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Property\ExtendPropertyCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\User\UserModelHandler;
use System\Classes\PluginBase;

/**
 * ApiShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    const EVENT_ITEMRESOURCE_DATA = 'planetadeleste.apishopaholic.resource.itemData';
    const API_ROUTES = '/planetadeleste/apishopaholic/routes/';

    public $require = [
        'Lovata.Shopaholic',
        'Lovata.Buddies',
        'PlanetaDelEste.BuddiesGroup',
        'PlanetaDelEste.ApiToolbox'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails(): array
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
        Event::subscribe(CategoryModelHandler::class);
        Event::subscribe(BrandModelHandler::class);
        Event::subscribe(ApiShopaholicHandle::class);
    }
}
