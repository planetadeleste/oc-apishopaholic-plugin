<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Event\User;

use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Models\User;
use Lovata\Toolbox\Classes\Event\ModelHandler;

/**
 * Class UserModelHandler
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\User
 */
class UserModelHandler extends ModelHandler
{
    const GROUP_ADMIN = 'admin';
    const GROUP_MANAGER = 'manager';

    /**
     * Add listeners
     *
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        User::extend(
            function ($obElement) {
                $this->extendModel($obElement);
            }
        );

        UserItem::extend(
            function ($obItem) {
                $this->extendItem($obItem);
            }
        );
    }

    /**
     * @param User $obModel
     */
    protected function extendModel($obModel)
    {
        $obModel->addDynamicMethod('scopeByGroup', function($obQuery, $code){
            /** @var \October\Rain\Database\Builder $obQuery */
            return $obQuery->whereHas(
                'groups',
                function ($query) use ($code) {
                    $query->where('code', $code);
                }
            );
        });

        $obModel->addDynamicMethod('scopeByAdmin', function($obQuery) {
            /** @var \October\Rain\Database\Builder $obQuery */
            return $obQuery->byGroup(static::GROUP_ADMIN);
        });
    }

    protected function extendItem($obItem)
    {

    }

    /**
     * @inheritDoc
     */
    protected function getModelClass()
    {
        return User::class;
    }

    /**
     * @inheritDoc
     */
    protected function getItemClass()
    {
        UserItem::class;
    }
}
