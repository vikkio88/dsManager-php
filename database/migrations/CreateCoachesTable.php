<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateCoachesTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        Capsule::schema()->dropIfExists('coaches');
        Capsule::schema()->create('coaches', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->tinyInteger('age');
            $table->string('nationality',2);
            $table->string('skillAvg');
            $table->float('wageReq');
            $table->string('favouriteModule',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coaches');
    }
}
