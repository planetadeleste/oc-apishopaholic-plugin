<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Exception;

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
    /**
     * @var \Lovata\Buddies\Models\User|\RainLab\User\Models\User|null
     */
    protected $user;

    /**
     * @var \Eloquent|\October\Rain\Database\Builder
     */
    protected $collection;

    /**
     * @var \Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $modelClass;

    /**
     * API Resource collection class used for list items
     *
     * @var null|string
     */
    protected $listResource = null;

    /**
     * API Resource collection class used for index
     *
     * @var null|string
     */
    protected $indexResource = null;

    /**
     * API Resource class for load item
     *
     * @var null|string
     */
    protected $showResource = null;

    /**
     * Primary column name for show element
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    protected $exists = false;

    /**
     * Default sort by column
     *
     * @var string
     */
    protected $sortColumn = 'created_at';

    /**
     * Default sort direction
     *
     * @var string
     */
    protected $sortDirection = 'desc';

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

            $this->collection = app($this->modelClass)->where($this->primaryKey, $value);

            if (!$this->collection) {
                throw new Exception('model_not_found', 403);
            }

            if (method_exists($this, 'extendShow')) {
                $this->extendShow();
            }

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

    protected function setResources()
    {
        if ($this->listResource && $this->indexResource && $this->showResource) {
            return;
        }

        $classname = ltrim(static::class, '\\');
        $arPath = explode('\\', $this->modelClass);
        $name = array_pop($arPath);
        list($author, $plugin) = explode('\\', $classname);
        $resourceClassBase = join('\\', [$author, $plugin, 'Classes', 'Resource', $name]);
        $this->showResource = $resourceClassBase.'\\ShowResource';
        $this->listResource = $resourceClassBase.'\\ListCollection';
        $this->indexResource = $resourceClassBase.'\\IndexCollection';
    }
}
