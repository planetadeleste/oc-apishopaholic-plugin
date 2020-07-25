<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;
use Lovata\Shopaholic\Models\Category;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Categories
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 *
 * @property \Lovata\Shopaholic\Classes\Collection\CategoryCollection $collection
 * @property Category                                                 $obModel
 */
class Categories extends Base
{
    /**
     * @api
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function tree()
    {
        try {
            if (!$this->getListResource()) {
                throw new Exception('listResource is required');
            }

            $obCollection = $this->collection->active()->tree();
            return app($this->getListResource(), [$obCollection->collect()]);
        } catch (Exception $e) {
            trace_log($e);
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function extendIndex()
    {
        $this->collection->sort();
    }

    /**
     * Save current model
     *
     * @return bool
     * @throws \Exception
     */
    public function save()
    {
        $this->obModel->fill($this->data);

        if (request()->hasFile('preview_image')) {
            $obFile = request()->file('preview_image');
            if ($obFile->isValid()) {
                if ($this->obModel->preview_image) {
                    $this->obModel->preview_image->delete();
                }

                $this->obModel->preview_image = $obFile;
            }
        }

        if (request()->hasFile('images')) {
            $arFiles = request()->file('images');
            if (!empty($arFiles)) {
                if ($this->obModel->images->count()) {
                    $this->obModel->images->each(function ($obImage){ $obImage->delete(); });
                }
                $this->obModel->images = $arFiles;
            }
        }

        return $this->obModel->save();
    }

    public function getModelClass()
    {
        return Category::class;
    }
}
