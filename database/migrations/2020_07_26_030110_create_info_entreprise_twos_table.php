<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoEntrepriseTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_entreprise_twos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('localisation');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('email');
            $table->string('langue');
            $table->text('description_services');
            $table->string('image');
            $table->text('enterprise_mission');
            $table->text('enterprise_ambition');
            $table->text('enterprise_value');
            $table->text('opening_hours'); 
            $table->text('enterprise_partner');
            $table->unsignedBigInteger('stepper_main_id');
            $table->foreign('stepper_main_id')->references('id')->on('stepper_mains');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_entreprise_twos');
    }
}
