<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartertrimestresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarter_trimestres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quarter_id');
            $table->unsignedBigInteger('trimestre_id');
            $table->timestamps();
              
            $table->foreign('trimestre_id')->references('id')->on('trimestres');
            $table->foreign('quarter_id')->references('id')->on('quarters')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quartertrimestres');
    }
}
