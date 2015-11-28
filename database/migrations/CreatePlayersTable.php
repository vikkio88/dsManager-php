<?php

use Illuminate\Database\Capsule\Manager as Capsule;

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
        Capsule::schema()->create('players', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->tinyInteger('age');
            $table->string('nationality',2);
            $table->string('skillAvg');
            $table->float('wageReq');
            $table->float('val');
            $table->string('role',2);
            $table->timestamps();
        });
    }
}