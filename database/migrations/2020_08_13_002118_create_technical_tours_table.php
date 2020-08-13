<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_tours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('car_id')->unsigned();
            $table->enum('type_intervention', ['provisoire', 'definitive']);
            $table->date('validity_date');
            $table->date('end_validity');
            $table->string('visited_by')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('amount')->nullable();
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
        Schema::drop('technical_tours');
    }
}
