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
    protected $modelClass = Category::class;

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function tree()
    {
        try {
            if (!$this->listResource) {
                throw new Exception('listResource is required');
            }

            $arListItems = $this->collection->tree()->values();
            return new $this->listResource(collect($arListItems));
        } catch (Exception $e) {
            trace_log($e);
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
