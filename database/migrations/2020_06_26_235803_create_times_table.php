<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('start_times');
            $table->time('end_times');
            $table->string('places');
            $table->boolean('isfree');
            $table->unsignedBigInteger('priest_planings_id');
            $table->timestamps();
            $table->foreign('priest_planings_id')->references('id')->on('priest_planings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times');
    }
}
