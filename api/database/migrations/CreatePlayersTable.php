<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreatePlayersTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('players');
        Capsule::schema()->create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->tinyInteger('age');
            $table->string('nationality',2);
            $table->float('skillAvg');
            $table->float('wageReq');
            $table->float('val');
            $table->string('role',2);
            $table->integer('team_id')->nullable();
            $table->timestamps();
        });
    }
}
