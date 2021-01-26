<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\Group;
use Lovata\Buddies\Models\User;
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

    public function init()
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

                if (array_get($arData, 'is_activated') && !$obModel->activated_at) {
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
}
