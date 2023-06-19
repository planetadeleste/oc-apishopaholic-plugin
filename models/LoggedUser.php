<?php

namespace PlanetaDelEste\ApiShopaholic\Models;

use Eloquent;
use Lovata\Buddies\Models\User;
use Lovata\Toolbox\Traits\Helpers\TraitCached;
use Model;
use October\Rain\Argon\Argon;
use October\Rain\Database\Builder;
use October\Rain\Database\Relations\BelongsTo;
use October\Rain\Database\Traits\Validation;

/**
 * Class LoggedUser
 *
 * @package PlanetaDelEste\ApiShopaholic\Models
 *
 * @mixin Builder
 * @mixin Eloquent
 *
 * @property integer $id
 * @property integer $user_id
 * @property Argon   $created_at
 * @property Argon   $last_activity_at
 * @property Argon   $updated_at
 *
 * @property User    $user
 * @method static BelongsTo|User user()
 * @method static Builder|self getByUser(int $iUserId)
 */
class LoggedUser extends Model
{
    use TraitCached;
    use Validation;

    /** @var string */
    public $table = 'planetadeleste_apishopaholic_loggedusers';

    /** @var array */
    public $rules = ['user_id' => 'required'];

    /** @var array */
    public $fillable = [
        'user_id',
        'last_activity_at'
    ];

    /** @var array */
    public $cached = [
        'id',
        'user_id',
        'last_activity_at',
        'created_at',
        'updated_at',
    ];

    /** @var array */
    public $dates = [
        'last_activity_at',
        'created_at',
        'updated_at',
    ];

    /** @var array */
    public $belongsTo = [
        'user' => [User::class]
    ];

    /**
     * @param Builder|self $obQuery
     * @param int|string   $iUserId
     * @return Builder|self
     */
    public function scopeGetByUser($obQuery, $iUserId)
    {
        return $obQuery->where('user_id', $iUserId);
    }
}
