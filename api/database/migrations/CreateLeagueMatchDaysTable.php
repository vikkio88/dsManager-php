<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreateLeagueMatchDaysTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('league_match_days');
        Capsule::schema()->create('league_match_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_id');
            $table->integer('day')->default(0);
            $table->timestamps();
        });
    }
}
