<?php
namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Lovata\Shopaholic\Classes\Collection\CategoryCollection;
use Lovata\Shopaholic\Models\Category;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ListCollection;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Categories
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 *
 * @property CategoryCollection $collection
 * @property Category           $obModel
 */
class Categories extends Base
{
    /**
     * @return ListCollection|JsonResponse
     */
    public function tree(): ListCollection|JsonResponse
    {
        try {
            if (!$this->getListResource()) {
                throw new Exception('listResource is required');
            }

            $this->fireSystemEvent('planetadeleste.apishopaholic.categories.extendTree', [&$this->collection], false);

            if (!$this->isBackend()) {
                $this->collection->active();
            }

            $obCollection = $this->collection->root();

            return new ListCollection($obCollection->collect());
        } catch (Exception $e) {
            trace_log($e);
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * Save current model
     *
     * @return bool
     * @throws Exception
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
