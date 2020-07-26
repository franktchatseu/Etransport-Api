<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_birth');
            $table->string('email');
            $table->string('tel1');
            $table->string('tel2');
            $table->string('address');
            $table->string('avatar');
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('stepper_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stepper_id')->references('id')->on('stepper_drivers');
            $table->foreign('nationality_id')->references('id')->on('nationalities');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_infos');
    }
}
