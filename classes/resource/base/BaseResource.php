<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Base;

use Event;
use Illuminate\Http\Resources\Json\Resource;

abstract class BaseResource extends Resource
{
    /** @var bool Add created_at, updated_at dates */
    public $addDates = true;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $arDataKeys = $this->getDataKeys();
        $arDates = $this->getDates();
        $arData = $this->getData();

        if (!empty($arDates) && $this->addDates) {
            $arData = $arData + $arDates;
        }

        if (!empty($arDataKeys)) {
            foreach ($arDataKeys as $sKey) {
                $arData[$sKey] = $this->{$sKey};
            }
        }

        if (is_string($this->getEvent())) {
            Event::fire($this->getEvent(), [&$arData, $this]);
        }

        return $arData;
    }

    /**
     * @return string|null
     */
    abstract protected function getEvent();

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return array
     */
    public function getDataKeys()
    {
        return [];
    }

    public function getDates()
    {
        return [
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
        ];
    }
}
