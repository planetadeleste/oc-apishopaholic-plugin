<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Item;

use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Toolbox\Classes\Item\ElementItem;

use October\Rain\Argon\Argon;
use PlanetaDelEste\ApiShopaholic\Models\LoggedUser;

/**
 * Class LoggedUserItem
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\ItemRef
 *
 * @property integer  $id
 * @property integer  $user_id
 * @property Argon    $created_at
 * @property Argon    $last_activity_at
 * @property Argon    $updated_at
 * @property UserItem $user
 */
class LoggedUserItem extends ElementItem
{
    public const MODEL_CLASS = LoggedUser::class;

    /** @var LoggedUser */
    protected $obElement = null;

    public $arRelationList = [
        'user' => [
            'class' => UserItem::class,
            'field' => 'user_id'
        ]
    ];
}
