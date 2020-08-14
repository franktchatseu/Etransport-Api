<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_interventions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('car_id')->unsigned();
            $table->string('card_number')->nullable();
            $table->string('status')->nullable();
            $table->string('receipt')->nullable();
            $table->string('index')->nullable();
            $table->string('degree_urgency')->nullable();
            $table->string('type_intervention')->nullable();
            $table->string('date_application')->nullable();
            $table->date('service_date')->nullable();
            $table->string('observation')->nullable();
            $table->string('initiated_by')->nullable();
            $table->date('commencement_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->time('starting_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('allocated_real_time')->nullable();
            $table->time('down_time')->nullable();
            $table->foreign('car_id')->references('id')->on('stepper_trees')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file_interventions');
    }
}
