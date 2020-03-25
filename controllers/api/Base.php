<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Event;
use Exception;
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
class Base
{
    use ApiBaseTrait;

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->setResources();

            if (!$this->indexResource) {
                throw new Exception('indexResource is required');
            }

            $this->collection = app()->make($this->modelClass);

            if ($this->collection->methodExists('scopeFrontend')) {
                $data = $this->filters();
                $this->collection->frontend($data['filters'], $data['sort']);
            }

            if (method_exists($this, 'extendIndex')) {
                $this->extendIndex();
            }

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
            $this->setResources();

            if (!$this->listResource) {
                throw new Exception('listResource is required');
            }

            $this->collection = app()->make($this->modelClass);

            if ($this->collection->methodExists('scopeFrontend')) {
                $data = $this->filters();
                $this->collection->frontend($data['filters'], $data['sort']);
            }

            if (method_exists($this, 'extendList')) {
                $this->extendList();
            }

            Event::fire(Plugin::EVENT_API_EXTEND_LIST, [$this, &$this->collection], true);

            return new $this->listResource($this->collection->get());
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
            $this->setResources();

            if (!$this->showResource) {
                throw new Exception('showResource is required');
            }

            Event::fire(Plugin::EVENT_API_BEFORE_SHOW_COLLECT, [$this, $value]);

            $this->collection = app($this->modelClass)->where($this->primaryKey, $value);

            if (!$this->collection->count()) {
                throw new Exception('model_not_found', 403);
            }

            if (method_exists($this, 'extendShow')) {
                $this->extendShow();
            }

            Event::fire(Plugin::EVENT_API_EXTEND_SHOW, [$this, &$this->collection], true);

            return new $this->showResource($this->collection->first());
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
}
