<?php

namespace PlanetaDelEste\ApiShopaholic\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableLoggedUsers
 *
 * @package PlanetaDelEste\ApiShopaholic\Classes\Console
 */
class CreateTableLoggedUsers extends Migration
{
    public const TABLE = 'planetadeleste_apishopaholic_loggedusers';

    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable(self::TABLE)) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $obTable) {
            $obTable->engine = 'InnoDB';
            $obTable->increments('id')->unsigned();
            $obTable->unsignedInteger('user_id');
            $obTable->timestamp('last_activity_at');
            $obTable->timestamps();
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
