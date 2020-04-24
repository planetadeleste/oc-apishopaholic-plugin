<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Base;

use Event;
use Illuminate\Http\Resources\Json\Resource;

abstract class BaseResource extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->getData();

        if (is_string($this->getEvent())) {
            Event::fire($this->getEvent(), [&$data, $this]);
        }

        return $data;
    }

    /**
     * @return string|null
     */
    abstract protected function getEvent();

    /**
     * @return array
     */
    abstract public function getData();
}
