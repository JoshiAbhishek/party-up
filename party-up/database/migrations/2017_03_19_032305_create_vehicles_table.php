<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle_id');
            $table->integer('owner_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
