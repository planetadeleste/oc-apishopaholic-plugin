<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\File;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;
use System\Models\File;

/**
 * Class ItemResource
 *
 * @mixin File
 */
class ItemResource extends Base
{
    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'thumb'     => $this->getThumb(600, 00, ['mode' => 'crop']),
            'path'      => $this->getPath(),
            'file_name' => $this->getFilename(),
            'ext'       => $this->getExtension(),
        ];
    }

    /**
     * @return string[]
     */
    public function getDataKeys(): array
    {
        return [
            'id',
            'attachment_id',
            'attachment_type',
            'created_at',
            'data',
            'description',
            'disk_name',
            'ext',
            'field',
            'file_name',
            'is_public',
            'path',
            'sort_order',
            'thumb',
            'title',
            'updated_at',
        ];
    }

    protected function getEvent(): ?string
    {
        return null;
    }
}
