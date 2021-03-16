<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\File;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin \System\Models\File
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\File
 */
class ItemResource extends Base
{
    public function getData(): array
    {
        return [
            'thumb'       => $this->getThumb(300, 300, ['mode' => 'crop']),
            'path'        => $this->getPath(),
            'file_name'   => $this->getFilename(),
            'ext'         => $this->getExtension(),
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'disk_name',
            'thumb',
            'path',
            'file_name',
            'ext',
            'title',
            'description',
        ];
    }

    protected function getEvent()
    {
        return null;
    }
}
