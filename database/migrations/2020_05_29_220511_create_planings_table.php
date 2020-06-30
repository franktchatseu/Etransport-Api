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
            $table->string('nature');
            $table->string('description');
            $table->unsignedBigInteger('parish_id');
            $table->string('place');
            $table->string('activity');
            $table->string('activityPro');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parish_id')->references('id')->on('parishs');

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
