<?php namespace PlanetaDelEste\ApiShopaholic\Traits\Controllers;

use Lovata\OrdersShopaholic\Classes\Collection\CartPositionCollection;
use Lovata\OrdersShopaholic\Classes\Collection\OrderCollection;
use Lovata\OrdersShopaholic\Classes\Collection\OrderPositionCollection;
use Lovata\OrdersShopaholic\Classes\Collection\PaymentMethodCollection;
use Lovata\OrdersShopaholic\Models\CartPosition;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\OrdersShopaholic\Models\OrderPosition;
use Lovata\OrdersShopaholic\Models\PaymentMethod;
use Lovata\Shopaholic\Classes\Collection\BrandCollection;
use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use Lovata\Shopaholic\Classes\Collection\CurrencyCollection;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Classes\Collection\PromoBlockCollection;
use Lovata\Shopaholic\Classes\Collection\TaxCollection;
use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Currency;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\PromoBlock;
use Lovata\Shopaholic\Models\Tax;

trait ApiBaseTrait
{
    /**
     * @var \Lovata\Buddies\Models\User|\RainLab\User\Models\User|null
     */
    protected $user;

    /**
     * @var \Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $modelClass;

    /**
     * API Resource collection class used for list items
     *
     * @var null|string
     */
    protected $listResource = null;

    /**
     * API Resource collection class used for index
     *
     * @var null|string
     */
    protected $indexResource = null;

    /**
     * API Resource class for load item
     *
     * @var null|string
     */
    protected $showResource = null;

    /**
     * @var bool
     */
    protected $exists = false;

    /**
     * @var \Lovata\Toolbox\Classes\Collection\ElementCollection
     */
    public $collection;

    /**
     * Primary column name for show element
     *
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * Default sort by column
     *
     * @var string
     */
    public $sortColumn = 'created_at';

    /**
     * Default sort direction
     *
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @return string
     */
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @return string|null
     */
    public function getListResource()
    {
        return $this->listResource;
    }

    /**
     * @return string|null
     */
    public function getIndexResource()
    {
        return $this->indexResource;
    }

    /**
     * @return string|null
     */
    public function getShopResource()
    {
        return $this->showResource;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->exists;
    }

    /**
     * @return \Lovata\Buddies\Models\User|\RainLab\User\Models\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    protected function setResources()
    {
        if ($this->listResource && $this->indexResource && $this->showResource) {
            return;
        }

        $classname = ltrim(static::class, '\\');
        $arPath = explode('\\', $this->modelClass);
        $name = array_pop($arPath);
        list($author, $plugin) = explode('\\', $classname);
        $resourceClassBase = join('\\', [$author, $plugin, 'Classes', 'Resource', $name]);
        $this->showResource = $resourceClassBase.'\\ShowResource';
        $this->listResource = $resourceClassBase.'\\ListCollection';
        $this->indexResource = $resourceClassBase.'\\IndexCollection';
    }

    /**
     * @return \Lovata\Toolbox\Classes\Collection\ElementCollection|null
     */
    protected function makeCollection()
    {
        // Main Shopaholic collections
        $arCollectionClasses = [
            Brand::class      => BrandCollection::class,
            Category::class   => CategoryCollection::class,
            Currency::class   => CurrencyCollection::class,
            Offer::class      => OfferCollection::class,
            Product::class    => ProductCollection::class,
            PromoBlock::class => PromoBlockCollection::class,
            Tax::class        => TaxCollection::class
        ];

        // OrderShopaholic plugin collections
        $arCollectionClasses += [
            CartPosition::class => CartPositionCollection::class,
            Order::class        => OrderCollection::class,
            OrderPosition::class => OrderPositionCollection::class,
            PaymentMethod::class => PaymentMethodCollection::class,

        ];

        if ($sCollectionClass = array_get($arCollectionClasses, $this->modelClass)) {
            return forward_static_call([$sCollectionClass, 'make']);
        }

        return null;
    }
}
