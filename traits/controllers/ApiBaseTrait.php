<?php namespace PlanetaDelEste\ApiShopaholic\Traits\Controllers;

trait ApiBaseTrait
{
    /**
     * @var \Lovata\Buddies\Models\User|\RainLab\User\Models\User|null
     */
    protected $user;

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
     * @var bool
     */
    protected $exists = false;

    /**
     * @var \Eloquent|\October\Rain\Database\Builder
     */
    public $collection;

    /**
     * Primary column name for show element
     *
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * Default sort by column
     *
     * @var string
     */
    public $sortColumn = 'created_at';

    /**
     * Default sort direction
     *
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @return string
     */
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @return string|null
     */
    public function getListResource()
    {
        return $this->listResource;
    }

    /**
     * @return string|null
     */
    public function getIndexResource()
    {
        return $this->indexResource;
    }

    /**
     * @return string|null
     */
    public function getShopResource()
    {
        return $this->showResource;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->exists;
    }

    /**
     * @return \Lovata\Buddies\Models\User|\RainLab\User\Models\User|null
     */
    public function getUser()
    {
        return $this->user;
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
