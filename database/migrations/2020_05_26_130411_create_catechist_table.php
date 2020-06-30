<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatechistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catechists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('catechist_date');
            $table->string('catechist_place');
            $table->timestamps();

            $table->unsignedBigInteger('user_utype_id');
            $table->foreign('user_utype_id')->references('id')->on('user_utypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catechists');
    }
}
