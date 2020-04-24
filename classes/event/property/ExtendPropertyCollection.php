<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Property;


use System\Classes\PluginManager;

class ExtendPropertyCollection
{
    public function subscribe()
    {
        if (PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            \Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection::extend(
                function ($obCollection) {
                    $this->addToSimpleArrayMethods($obCollection);
                }
            );
        }
    }

    /**
     * @param \Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection $obCollection
     */
    protected function addToSimpleArrayMethods($obCollection)
    {
        $obCollection->addDynamicMethod(
            'toSimpleArray',
            function () use ($obCollection) {
                $arProperties = [];

                if ($obCollection->isEmpty()) {
                    return $arProperties;
                }

                /** @var \Lovata\PropertiesShopaholic\Classes\Item\PropertyItem $obProperty */
                foreach ($obCollection->all() as $obProperty) {
                    if (!$obProperty->hasValue()) {
                        continue;
                    }

                    $arProperties[] = [
                        'code'        => $obProperty->code,
                        'name'        => $obProperty->name,
                        'value'       => $obProperty->property_value->getValueString(),
                        'description' => $obProperty->description
                    ];
                }

                return $arProperties;
            }
        );
    }
}
