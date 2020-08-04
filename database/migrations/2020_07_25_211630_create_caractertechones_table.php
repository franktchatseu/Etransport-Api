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
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('mark_id');
            $table->unsignedBigInteger('carosserie_id');
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

            $table->foreign('stepper_id')->references('id')->on('stepper_trees')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mark_id')->references('id')->on('marks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('carosserie_id')->references('id')->on('carosseries')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracter_tech_ones');
    }
}
