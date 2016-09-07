<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreateMatchTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('matches');
        Capsule::schema()->create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_round_id')->nullable();
            $table->integer('home_team_id');
            $table->integer('goal_home')->default(0);
            $table->integer('away_team_id');
            $table->integer('winner_id')->default(null);
            $table->integer('loser_id')->default(null);
            $table->integer('goal_away')->default(0);
            $table->boolean('is_draw')->default(false);
            $table->boolean('simulated')->default(false);
            $table->date('match_date')->default(\Carbon\Carbon::now());
            $table->timestamps();
        });
    }
}
