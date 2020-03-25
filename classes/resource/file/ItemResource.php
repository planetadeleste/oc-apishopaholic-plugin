<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\File;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class ItemResource
 *
 * @mixin \System\Models\File
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\File
 */
class ItemResource extends Resource
{
    public function toArray($request)
    {
        return [
            'thumb'       => $this->getThumb(300, 300, ['mode' => 'crop']),
            'path'        => $this->getPath(),
            'file_name'   => $this->getFilename(),
            'ext'         => $this->getExtension(),
            'title'       => $this->title,
            'description' => $this->description
        ];
    }
}
