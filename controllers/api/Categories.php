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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function tree()
    {
        try {
            if (!$this->getListResource()) {
                throw new Exception('listResource is required');
            }

            if (!$this->isBackend()) {
                $this->collection->active();
            }

            $obCollection = $this->collection->root();
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
    public function save(): bool
    {
        $this->obModel->fill($this->data);

        if ($iParentId = array_get($this->data, 'parent_id')) {
            $obCategory = Category::find($iParentId);
            if ($obCategory) {
                $this->obModel->parent()->associate($obCategory);
            }
        }

        return $this->saveAndAttach();
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Category::class;
    }
}
