<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoEntrepriseOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_entreprise_ones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('taxpayer_number');
            $table->integer('rccm_number');
            $table->string('billing_address');
            $table->integer('gear_number');
            $table->integer('driver_number');
            $table->string('manager_name');
            $table->string('manager_function');
            $table->string('manager_phone');
            $table->string('manager_picture');
            $table->unsignedBigInteger('stepper_main_id');
            $table->foreign('stepper_main_id')->references('id')->on('stepper_mains');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_entreprise_ones');
    }
}
