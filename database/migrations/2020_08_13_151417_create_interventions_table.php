<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('range_id')->unsigned();
            $table->integer('file_id')->unsigned();
            $table->string('organ')->nullable();
            $table->string('speaker')->nullable();
            $table->string('cost_maintenance')->nullable();
            $table->string('does')->nullable();
            $table->string('duration')->nullable();
            $table->foreign('range_id')->references('id')->on('range_actions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('file_id')->references('id')->on('file_interventions')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interventions');
    }
}
