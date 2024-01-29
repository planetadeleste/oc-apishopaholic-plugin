<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Event\User;

use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Models\Group;
use Lovata\Buddies\Models\User;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use PlanetaDelEste\ApiShopaholic\Classes\Store\UserListStore;
use PlanetaDelEste\ApiShopaholic\Models\LoggedUser;
use PlanetaDelEste\BuddiesGroup\Classes\Collection\UserCollection;

/**
 * Class UserModelHandler
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Event\User
 *
 * @property User $obElement
 */
class UserModelHandler extends ModelHandler
{
    public const GROUP_ADMIN   = 'admin';
    public const GROUP_MANAGER = 'manager';

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

        UserCollection::extend(function ($obCollection) {
            $this->extendCollection($obCollection);
        });
    }

    /**
     * @param User $obModel
     */
    protected function extendModel(User $obModel)
    {
        $obModel->addCachedField(['is_activated', 'created_at', 'updated_at', 'last_login', 'role']);
        $obModel->addDynamicMethod(
            'scopeByGroup',
            function ($obQuery, $code) {
                /** @var \October\Rain\Database\Builder $obQuery */
                return $obQuery->whereHas(
                    'groups',
                    function ($query) use ($code) {
                        $query->where('code', $code);
                    }
                );
            }
        );

        $obModel->addDynamicMethod(
            'scopeByAdmin',
            function ($obQuery) {
                /** @var \October\Rain\Database\Builder $obQuery */
                return $obQuery->byGroup(static::GROUP_ADMIN);
            }
        );

        $obModel->addDynamicMethod(
            'getRoleAttribute',
            function () use ($obModel) {
                $arGroups = $obModel->groups()->lists('code');
                $sCode    = count($arGroups) == 1 ? $arGroups[0] : 'guest';
                if (count($arGroups) > 1) {
                    $arGroups = array_filter(
                        $arGroups,
                        function ($sCode) {
                            return !in_array($sCode, ['registered', 'guest']);
                        }
                    );
                    $sCode    = array_first($arGroups);
                }
                return $sCode;
            }
        );

        $obModel->addDynamicMethod('getLastActivityAtAttribute', function () use ($obModel) {
            $obLoggedUser = LoggedUser::getByUser($obModel->id)->latest('last_activity_at')->first();
            return $obLoggedUser ? $obLoggedUser->last_activity_at : null;
        });
    }

    protected function extendItem(UserItem $obItem)
    {
        $obItem->addDynamicMethod(
            'getRoleAttribute',
            function () use ($obItem) {
                $sCode = $obItem->getObject()->role;
                $obItem->setAttribute('role', $sCode);
                return $sCode;
            }
        );

        $obItem->addDynamicMethod('getLastActivityAtAttribute', function () use ($obItem) {
            $obDate = $obItem->getObject()->last_activity_at;
            $obItem->setAttribute('last_activity_at', $obDate);

            return $obDate;
        });
    }

    protected function extendCollection(UserCollection $obCollection)
    {
        $obCollection->addDynamicMethod('logged', function () use ($obCollection) {
            $arResultIdList = UserListStore::instance()->logged->get();

            return $obCollection->intersect($arResultIdList);
        });
    }

    protected function afterSave()
    {
        parent::afterSave();
        $this->obElement->purgeAttributes();
        $this->obElement->password = null;

        if (!$this->obElement->groups->count()) {
            $obGroup = Group::firstOrCreate(
                ['code' => 'guest'],
                [
                    'name'        => 'Guest',
                    'description' => 'Default group for guest users.'
                ]
            );
            $this->obElement->addGroup($obGroup);
            $this->obElement->save();
        }
    }

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @inheritDoc
     */
    protected function getItemClass(): string
    {
        return UserItem::class;
    }
}
