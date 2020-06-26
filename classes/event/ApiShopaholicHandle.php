<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event;


use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ListCollection;
use PlanetaDelEste\ApiShopaholic\Plugin;

class ApiShopaholicHandle
{
    /**
     * @param \October\Rain\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen(
            Plugin::EVENT_ITEMRESOURCE_DATA,
            function ($arData, $obItemResource) {
                return $this->onExtendItem($arData, $obItemResource);
            }
        );
    }

    /**
     * @param array                                                            $arData
     * @param \PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource $obItemResource
     *
     * @return array
     */
    protected function onExtendItem($arData, $obItemResource)
    {
        if ($obItemResource instanceof ItemResourceCategory) {
            if (input('filters.tree')) {
                return [
                    'children' => empty($obItemResource->children_id_list)
                        ? []
                        : ListCollection::make($obItemResource->children->collect())
                ];
            }
        }

        return null;
    }
}
