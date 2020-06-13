<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationplanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_plannings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('planing_id');
            $table->timestamps();
            $table->foreign('association_id')->references('id')->on('associations');
            $table->foreign('planing_id')->references('id')->on('planings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('association_plannings');
    }
}
