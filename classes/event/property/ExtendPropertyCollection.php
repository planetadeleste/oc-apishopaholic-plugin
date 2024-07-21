<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Property;

use Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection;
use Lovata\PropertiesShopaholic\Classes\Item\PropertyItem;
use System\Classes\PluginManager;

class ExtendPropertyCollection
{
    /**
     * @return void
     */
    public function subscribe(): void
    {
        if (!PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            return;
        }

        PropertyCollection::extend(
            function ($obCollection): void {
                $this->addToSimpleArrayMethods($obCollection);
            }
        );
    }

    /**
     * @param PropertyCollection $obCollection
     */
    protected function addToSimpleArrayMethods(PropertyCollection $obCollection): void
    {
        $obCollection->addDynamicMethod(
            'toSimpleArray',
            static function () use ($obCollection) {
                $arProperties = [];

                if ($obCollection->isEmpty()) {
                    return $arProperties;
                }

                /** @var PropertyItem $obProperty */
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
