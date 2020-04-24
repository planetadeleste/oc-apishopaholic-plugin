<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Lovata\Toolbox\Classes\Collection\ElementCollection;

/**
 * Class ExtendElementCollection
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event
 */
class ExtendElementCollection
{
    public function subscribe()
    {
        ElementCollection::extend(
            function ($obCollection) {
                $this->addValuesMethod($obCollection);
                $this->addPaginateMethod($obCollection);
                $this->addCollectMethod($obCollection);
            }
        );
    }

    /**
     * Add "paginate" method to collection class
     *
     * @param ElementCollection $obCollection
     */
    protected function addPaginateMethod($obCollection)
    {
        $obCollection->addDynamicMethod(
            'paginate',
            function ($pageSize = 10, $page = null, $pageName = 'page') use ($obCollection) {
                $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
                $total = $obCollection->count();
                $arItems = $obCollection->page($page, $pageSize);
                if(!empty($arItems)) {
                    $arItems = array_values($arItems);
                }
                return self::paginator(
                    collect($arItems),
                    $total,
                    $pageSize,
                    $page,
                    [
                        'path'     => Paginator::resolveCurrentPath(),
                        'pageName' => $pageName,
                    ]
                );
            }
        );
    }

    /**
     * @param ElementCollection $obCollection
     */
    protected function addValuesMethod($obCollection)
    {
        $obCollection->addDynamicMethod('values', function() use ($obCollection) {
            return array_values( $obCollection->all() );
        });
    }

    /**
     * @param ElementCollection $obCollection
     */
    protected function addCollectMethod($obCollection)
    {
        $obCollection->addDynamicMethod('collect', function() use ($obCollection) {
            return collect($obCollection->all());
        });
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param \Illuminate\Support\Collection $items
     * @param int                            $total
     * @param int                            $perPage
     * @param int                            $currentPage
     * @param array                          $options
     *
     * @return LengthAwarePaginator
     */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(
            LengthAwarePaginator::class,
            compact(
                'items',
                'total',
                'perPage',
                'currentPage',
                'options'
            )
        );
    }
}
