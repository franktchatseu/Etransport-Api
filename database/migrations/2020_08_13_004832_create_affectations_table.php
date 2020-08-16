<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('car_id')->unsigned();
            $table->bigInteger('driver_id')->unsigned();
            $table->string('remorque')->nullable();
            $table->bigInteger('conveyor_id')->unsigned()->nullable();
            $table->date('date')->nullable();
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
        Schema::drop('affectations');
    }
}
