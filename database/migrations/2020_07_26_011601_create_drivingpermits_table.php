<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrivingpermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->date('date_issue');
            $table->string('place_issue');
            $table->unsignedBigInteger('stepper_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stepper_id')->references('id')->on('stepper_drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driving_permits');
    }
}
