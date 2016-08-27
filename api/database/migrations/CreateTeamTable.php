<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreateTeamTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('teams');
        Capsule::schema()->create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nationality',2);
            $table->timestamps();
        });
    }
}
