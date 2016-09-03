<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint as Blueprint;

class CreateLeaguesTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('leagues');
        Capsule::schema()->create('leagues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }
}
