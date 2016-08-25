<?php

use Illuminate\Database\Capsule\Manager as Capsule;

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
        Capsule::schema()->create('teams', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nationality',2);
            $table->timestamps();
        });
    }
}
