<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;
use Kharanenka\Helper\Result;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use System\Models\File;
use ToughDeveloper\ImageResizer\Classes\Image;

/**
 * Class Files
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Files extends Base
{
    /**
     * @param string $sDiskName
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function thumb(string $sDiskName)
    {
        try {
            $iWidth = array_get($this->data, 'width', 0);
            $iHeight = array_get($this->data, 'height', 150);
            /** @var File $obFile */
            $obFile = File::where('disk_name', $sDiskName)->first();
            if (!$obFile) {
                throw new Exception(static::ALERT_RECORD_NOT_FOUND, 403);
            }

            return $this->resize($obFile, $iWidth, $iHeight);

        } catch (Exception $e) {
            return static::exceptionResult($e);
        }
    }

    /**
     * @param \System\Models\File $obFile
     * @param int                 $iWidth
     * @param int                 $iHeight
     *
     * @return array
     */
    protected function resize(File $obFile, $iWidth = 0, $iHeight = 0): array
    {
        $obImage = new Image($obFile);
        $obImage->resize($iWidth, $iHeight);

        return Result::setTrue(['path' => $obImage->getCachedImagePath(true)])->get();
    }

    public function getModelClass()
    {
        return File::class;
    }
}
