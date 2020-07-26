<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stepper_id');
            $table->date('patent_validation');
            $table->date('insurance_validation_date');
            $table->date('technical_visit_date');
            $table->foreign('stepper_id')->references('id')->on('stepper_trees')->onDelete('cascade');
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
        Schema::dropIfExists('car_papers');
    }
}
