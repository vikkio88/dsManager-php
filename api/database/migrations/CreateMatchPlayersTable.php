<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreateMatchPlayersTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('match_players');
        Capsule::schema()->create('match_players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id');
            $table->integer('team_id');
            $table->integer('player_id')->default(0);
            $table->unsignedTinyInteger('goals')->default(0);
            $table->unsignedTinyInteger('vote')->default(6);
            $table->timestamps();
        });
    }
}
