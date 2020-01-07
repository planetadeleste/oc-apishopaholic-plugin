<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class itemResource
 *
 * @mixin \Lovata\Shopaholic\Models\Category
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class ItemResource extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|void
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'slug'          => $this->slug,
            'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
            'text'          => $this->name,
            'value'         => $this->id,
        ];
    }
}
