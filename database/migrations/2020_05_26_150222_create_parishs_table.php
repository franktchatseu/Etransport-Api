<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParishsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parishs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('decision_creation');
            $table->date('Pattern_date');
            $table->integer('nbr_of_structure');
            $table->integer('nbr_of_service');
            $table->integer('nbr_of_group');
            $table->integer('nbr_of_ceb');
            $table->integer('nbr_of_station');
            $table->integer('nbr_of_seminarist');
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
        Schema::dropIfExists('parishs');
    }
}
