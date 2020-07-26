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
     * @return \Illuminate\Http\JsonResponse|mixed
     * @api
     *
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
        $this->saveImages();

        if ($iParentId = array_get($this->data, 'parent_id')) {
            $obCategory = Category::find($iParentId);
            if ($obCategory) {
                $this->obModel->parent()->associate($obCategory);
            }
        }

        return $this->obModel->save();
    }

    public function getModelClass()
    {
        return Category::class;
    }
}
