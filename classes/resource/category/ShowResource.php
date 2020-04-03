<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use Event;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class showResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\CategoryItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class ShowResource extends ItemResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|void
     */
    public function toArray($request)
    {
        $data = array_merge(
            parent::toArray($request),
            [
                'updated_at'    => $this->updated_at->toDateTimeString(),
                'preview_text'  => $this->preview_text,
                'description'   => $this->description
            ]
        );

        Event::fire(Plugin::EVENT_SHOWRESOURCE_DATA, [&$data, $this]);

        return $data;
    }
}
