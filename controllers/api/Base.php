<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Event;
use Exception;
use Illuminate\Routing\Controller;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiShopaholic\Traits\Controllers\ApiBaseTrait;

/**
 * Class Base
 *
 * @method void extendIndex()
 * @method void extendList()
 * @method void extendShow()
 * @method void extendDestroy()
 * @method void extendFilters(array &$filters)
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Base extends Controller
{
    use ApiBaseTrait;

    public function __construct()
    {
        $this->setResources();
        $this->collection = $this->makeCollection();
        $this->collection = $this->applyFilters();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            if (!$this->indexResource) {
                throw new Exception('indexResource is required');
            }

            if (method_exists($this, 'extendIndex')) {
                $this->extendIndex();
            }

            /**
             * Extend collection results
             */
            Event::fire(Plugin::EVENT_API_EXTEND_INDEX, [$this, &$this->collection], true);

            return new $this->indexResource($this->collection->paginate());
        } catch (Exception $e) {
            trace_log($e);
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        try {
            if (!$this->listResource) {
                throw new Exception('listResource is required');
            }

            if (method_exists($this, 'extendList')) {
                $this->extendList();
            }

            /**
             * Extend collection results
             */
            Event::fire(Plugin::EVENT_API_EXTEND_LIST, [$this, &$this->collection], true);

            $arListItems = $this->collection->values();
            return new $this->listResource(collect($arListItems));
        } catch (Exception $e) {
            trace_log($e);
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * @param int|string $value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($value)
    {
        try {
            if (!$this->showResource) {
                throw new Exception('showResource is required');
            }

            /**
             * Fire event before show item
             */
            Event::fire(Plugin::EVENT_API_BEFORE_SHOW_COLLECT, [$this, $value]);

            /** @var int|null $iModelId */
            $iModelId = app($this->modelClass)->where($this->primaryKey, $value)->value('id');

            if (!$iModelId) {
                throw new Exception('model_not_found', 403);
            }

            $sItemClass = $this->collection::ITEM_CLASS;
            $this->item = $sItemClass::make($iModelId);
            debug($this->item);

            if (method_exists($this, 'extendShow')) {
                $this->extendShow();
            }

            /**
             * Extend collection results
             */
            Event::fire(Plugin::EVENT_API_EXTEND_SHOW, [$this, $this->item], true);

            return new $this->showResource($this->item);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        try {
            throw new Exception('Comming soon');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        try {
            throw new Exception('Comming soon');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            throw new Exception('Comming soon');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * @return array
     *  [
     *      'sort' => [
     *          'column'    => 'created_at',
     *          'direction' => 'desc'
     *      ],
     *      'filters' => []
     *   ]
     */
    protected function filters()
    {
        $sortDefault = [
            'column'    => $this->sortColumn,
            'direction' => $this->sortDirection
        ];
        $sort = get('sort', []);
        if (is_string($sort)) {
            $json = json_decode($sort, true);
            if (!json_last_error()) {
                $sort = $json;
            }
        }
        $sort = array_merge($sortDefault, $sort);

        if (!$filters = get('filters')) {
            $filters = get();
        }
        if (is_string($filters)) {
            $json = json_decode($filters, true);
            if (!json_last_error()) {
                $filters = $json;
            }
        }

        if (method_exists($this, 'extendFilters')) {
            $this->extendFilters($filters);
        }

        return compact('sort', 'filters');
    }

    /**
     * @return \Lovata\Toolbox\Classes\Collection\ElementCollection|mixed|null
     */
    protected function applyFilters()
    {
        if (!$this->collection) {
            return null;
        }

        $data = $this->filters();
        $arFilters = array_get($data, 'filters');
        $arSort = array_get($data, 'sort');
        $obCollection = $this->collection;


        if (!empty($arFilters)) {
            if ($obCollection->methodExists('filter')) {
                $obCollection = $obCollection->filter($arFilters);
            }
            foreach ($arFilters as $sFilterName => $sFilterValue) {
                if ($obCollection->methodExists($sFilterName)) {
                    $obCollection = call_user_func_array(
                        [$obCollection, $sFilterName],
                        array_wrap($sFilterValue)
                    );
                }
            }
        }

        if ($this->collection->methodExists('sort') && $arSort['column'] !== 'no') {
            $obCollection = $obCollection->sort($arSort['column'].'|'.$arSort['direction']);
        }

        return $obCollection;
    }
}
