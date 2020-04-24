<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\Property;


use Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection;

class ExtendPropertyCollection
{
    public function subscribe()
    {
        PropertyCollection::extend(
            function ($obCollection) {
                $this->addToSimpleArrayMethods($obCollection);
            }
        );
    }

    /**
     * @param PropertyCollection $obCollection
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
