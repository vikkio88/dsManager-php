<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreateLeagueRoundsTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('league_rounds');
        Capsule::schema()->create('league_rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_id');
            $table->boolean('simulated')->default(false);
            $table->integer('day')->default(0);
            $table->timestamps();
        });
    }
}
