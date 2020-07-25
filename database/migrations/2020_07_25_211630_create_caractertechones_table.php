<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaractertechonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracter_tech_ones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('registration');
            $table->string('country_registration');
            $table->unsignedBigInteger('stepper_id');
            $table->double('length');
            $table->double('width');
            $table->double('height');
            $table->double('volume');
            $table->double('total_weight');
            $table->double('live_load');
            $table->double('empty_weight');
            $table->double('power');
            $table->string('chassis_number');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stepper_id')->references('id')->on('stepper_trees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caractertechones');
    }
}
