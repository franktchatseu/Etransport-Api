<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearpicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gear_pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fore_gear');
            $table->string('rear_gear');
            $table->string('left_side_gear');
            $table->string('right_side_gear');
            $table->string('insurance_patente');
            $table->string('grey_card');
            $table->unsignedBigInteger('stepper_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stepper_id')->references('id')->on('stepper_trees')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gear_pictures');
    }
}
