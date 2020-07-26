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
            $table->Integer('location');
            $table->unsignedBigInteger('stepper_id');
            $table->string('tel1');
            $table->string('tel2');
            $table->string('email');
            $table->string('langue');
            $table->text('description_entreprise_service');
            $table->String('image');
            $table->text('mission_enterprise');
            $table->text('embition_enterprise');
            $table->text('value_enterprise');
            $table->time('open_hour');
            $table->string('partner_enterprise');
            $table->foreign('stepper_id')->references('id')->on('stepper_mains')->onDelete('cascade');
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
