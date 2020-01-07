<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Product;

use Event;
use Lovata\PropertiesShopaholic\Classes\Collection\PropertyCollection;
use Lovata\PropertiesShopaholic\Classes\Helper\CommonPropertyHelper;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Plugin;

/**
 * Class showResource
 *
 * @mixin \Lovata\Shopaholic\Models\Product
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
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
                'active'        => $this->active,
                'external_id'   => $this->external_id,
                'preview_text'  => $this->preview_text,
                'description'   => $this->description,
                'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
                'category'      => $this->category ? ItemResourceCategory::make($this->category) : null,
                'images'        => IndexCollectionImages::make($this->images),
                'property'      => $this->formatProperty()
            ]
        );

        Event::fire(Plugin::EVENT_SHOWRESOURCE_DATA, [&$data, $this]);

        return $data;
    }

    protected function formatProperty()
    {
        $collection = collect(PropertyCollection::make(array_keys($this->property))->pluck('code'));
        return $collection->combine(array_values($this->property))->all();
    }
}
