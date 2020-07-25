<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stepper_id');
            $table->date('required_workday');
            $table->time('time_required');
            $table->text('equipment');
            $table->text('usage');
            $table->text('usual_location');
            $table->text('observation');
            $table->string('owner');
            $table->foreign('stepper_id')->references('id')->on('stepper_trees')->onDelete('cascade');
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
        Schema::dropIfExists('descriptions');
    }
}
