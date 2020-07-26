<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalComputingSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_computing_specials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('name');
            $table->unsignedBigInteger('stepper_id');
            $table->string('surmane');
            $table->string('tel2');
            $table->string('email');
            $table->string('langue');
            $table->text('tel1');
            $table->String('image');
            $table->text('adress');
            $table->text('gear_count');
            $table->text('driver_number');
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
        Schema::dropIfExists('personal_computing_specials');
    }
}
