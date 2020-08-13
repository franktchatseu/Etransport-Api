<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('car_id')->unsigned();
            $table->bigInteger('insurer_id')->unsigned();
            $table->date('validity_date');
            $table->date('end_validity');
            $table->string('bonus')->nullable();
            $table->string('policy_number')->nullable();
            $table->foreign('car_id')->references('id')->on('stepper_trees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('insurer_id')->references('id')->on('transport_elements')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('insurances');
    }
}
