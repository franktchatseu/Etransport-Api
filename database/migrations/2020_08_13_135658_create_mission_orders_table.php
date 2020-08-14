<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('car_id')->unsigned();
            $table->bigInteger('driver_id')->unsigned();
            $table->bigInteger('conveyor_id')->unsigned();
            $table->string('number')->nullable();
            $table->string('file_number')->nullable();
            $table->string('subject')->nullable();
            $table->date('date_departure')->nullable();
            $table->date('return_date')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('return_time')->nullable();
            $table->time('duration')->nullable();
            $table->string('start_index')->nullable();
            $table->string('return_index')->nullable();
            $table->string('actual_course')->nullable();
            $table->string('theorical_course')->nullable();
            $table->string('departure_city')->nullable();
            $table->string('fuel')->nullable();
            $table->boolean('factory_return')->nullable();
            $table->foreign('car_id')->references('id')->on('stepper_trees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('driver_id')->references('id')->on('stepper_drivers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('conveyor_id')->references('id')->on('stepper_drivers')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mission_orders');
    }
}
