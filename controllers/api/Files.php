<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use System\Models\File;

/**
 * Class Files
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Files extends Base
{
    public function getModelClass()
    {
        return File::class;
    }
}
