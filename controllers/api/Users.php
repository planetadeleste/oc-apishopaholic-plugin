<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\Group;
use Lovata\Buddies\Models\User;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\IndexCollection;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ShowResource;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiToolbox\Plugin;
use PlanetaDelEste\BuddiesGroup\Classes\Store\UserListStore;

/**
 * Class Users
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 */
class Users extends Base
{
    protected $arFileList = ['attachOne' => 'avatar'];

    public function init(): void
    {
        $this->bindEvent(
            Plugin::EVENT_LOCAL_AFTER_SAVE,
            function (User $obModel, $arData) {
                $arGroups = array_get($arData, 'groups');
                if (!empty($arGroups)) {
                    $arUserGroupListID = [];
                    foreach ($arGroups as $sGroupCode) {
                        $obGroup = Group::getByCode($sGroupCode)->first();
                        if ($obGroup) {
                            $arUserGroupListID[] = $obGroup->id;
                        }
                    }
                    $obModel->groups()->sync($arUserGroupListID);
                }

                if (array_get($arData, 'is_activated')) {
                    $obModel->activate();
                    $obModel->save();
                } elseif ($obModel->is_activated) {
                    $obModel->is_activated = false;
                    $obModel->activated_at = null;
                    $obModel->save();
                }
            }
        );
    }

    public function getModelClass(): string
    {
        return User::class;
    }

    public function getSortColumn(): ?string
    {
        return UserListStore::SORT_BY_LATEST;
    }

    public function getShowResource(): string
    {
        return ShowResource::class;
    }

    public function getListResource(): string
    {
        return IndexCollection::class;
    }

    public function getIndexResource(): string
    {
        return IndexCollection::class;
    }
}
