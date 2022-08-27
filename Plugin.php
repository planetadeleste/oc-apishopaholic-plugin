<?php namespace PlanetaDelEste\ApiShopaholic;

use Event;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ApiShopaholicHandle;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Brand\BrandModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Category\CategoryModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ExtendElementCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Property\ExtendPropertyCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Tax\TaxModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\User\UserModelHandler;
use System\Classes\PluginBase;

/**
 * ApiShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    public const EVENT_ITEMRESOURCE_DATA = 'planetadeleste.apishopaholic.resource.itemData';
    public const EVENT_LOCALE_BEFORE_CHANGE = 'planetadeleste.apishopaholic.locale.beforeChange';
    public const EVENT_LOCALE_AFTER_CHANGE = 'planetadeleste.apishopaholic.locale.afterChange';
    public const API_ROUTES = '/planetadeleste/apishopaholic/routes/';

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

    public function boot(): void
    {
        $this->subscribeEvents();
    }

    protected function subscribeEvents(): void
    {
        $arEvents = [
            ExtendElementCollection::class,
            ExtendPropertyCollection::class,
            UserModelHandler::class,
            CategoryModelHandler::class,
            BrandModelHandler::class,
            ApiShopaholicHandle::class,
            TaxModelHandler::class,
        ];
        array_walk($arEvents, [Event::class, 'subscribe']);
    }
}
