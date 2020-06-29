<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriestPlaningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priest_planings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->date('date');
            $table->unsignedBigInteger('user_utype_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('time_id');
            $table->timestamps();
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('user_id')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priest_planings');
    }
}
