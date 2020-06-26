<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserparishsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_parishs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_utype_id');
            $table->unsignedBigInteger('parish_id');
            $table->boolean('is_active');
            $table->timestamps();
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('parish_id')->references('id')->on('parishs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_parishs');
    }
}
