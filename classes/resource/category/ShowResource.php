<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

/**
 * Class showResource
 *
 * @mixin \Lovata\Shopaholic\Models\Category
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
                'created_at'    => $this->created_at->toDateTimeString(),
                'updated_at'    => $this->updated_at->toDateTimeString(),
                'active'        => $this->active,
                'external_id'   => $this->external_id,
                'preview_text'  => $this->preview_text,
                'description'   => $this->description
            ]
        );

        return $data;
    }
}
