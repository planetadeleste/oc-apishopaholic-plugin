<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;
use Lovata\Shopaholic\Models\Category;

/**
 * Class Categories
 *
 * @property \Lovata\Shopaholic\Classes\Collection\CategoryCollection $collection
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Categories extends Base
{
    /**
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

    public function getModelClass()
    {
        return Category::class;
    }
}
