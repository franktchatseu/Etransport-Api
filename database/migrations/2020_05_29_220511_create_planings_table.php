<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('nature');
            $table->string('description');
            $table->unsignedBigInteger('user_utype_id');
            $table->string('place');
            $table->string('activity');
            $table->string('activityPro');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_utype_id')->references('id')->on('user_utypes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planings');
    }
}
