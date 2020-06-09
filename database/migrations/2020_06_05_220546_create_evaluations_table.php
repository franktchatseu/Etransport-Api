<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('evaluation_type');
            $table->double('note');
            $table->timestamps();
            $table->unsignedBigInteger('trimestres_id');
            $table->unsignedBigInteger('annual_member_id');

            $table->foreign('trimestres_id')->references('id')->on('trimestres');
            $table->foreign('annual_member_id')->references('id')->on('annual_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
