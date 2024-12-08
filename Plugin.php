<?php

namespace PlanetaDelEste\ApiShopaholic;

use Event;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Session\Middleware\StartSession;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ApiShopaholicHandle;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Brand\BrandModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Category\CategoryModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\ExtendElementCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\LoggedUser\LoggedUserModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\PriceType\ExtendPriceTypeColumnsHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\PriceType\ExtendPriceTypeFieldsHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Product\ProductModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Property\ExtendPropertyCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Event\Tax\TaxModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Event\User\UserModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Middleware\RefreshLoggedUserMiddleware;
use System\Classes\PluginBase;

/**
 * ApiShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    public const string EVENT_ITEMRESOURCE_DATA    = 'planetadeleste.apishopaholic.resource.itemData';
    public const string EVENT_LOCALE_BEFORE_CHANGE = 'planetadeleste.apishopaholic.locale.beforeChange';
    public const string EVENT_LOCALE_AFTER_CHANGE  = 'planetadeleste.apishopaholic.locale.afterChange';
    public const string API_ROUTES                 = '/planetadeleste/apishopaholic/routes/';

    /**
     * @var array<string>
     */
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

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->subscribeEvents();
        $this->app[Kernel::class]->pushMiddleware(RefreshLoggedUserMiddleware::class);
        $this->app[Kernel::class]->pushMiddleware(StartSession::class);
    }

    /**
     * @return void
     */
    protected function subscribeEvents(): void
    {
        $arEvents = [
            ApiShopaholicHandle::class,
            BrandModelHandler::class,
            CategoryModelHandler::class,
            ExtendElementCollection::class,
            ExtendPriceTypeColumnsHandler::class,
            ExtendPriceTypeFieldsHandler::class,
            ExtendPropertyCollection::class,
            LoggedUserModelHandler::class,
            ProductModelHandler::class,
            TaxModelHandler::class,
            UserModelHandler::class,
        ];
        array_walk($arEvents, [Event::class, 'subscribe']);
    }
}
