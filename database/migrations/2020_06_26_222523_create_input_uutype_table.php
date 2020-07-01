<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputUutypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_uutypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_utype_id');
            $table->unsignedBigInteger('parish_id');
            $table->unsignedBigInteger('input_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('amount');
            $table->date('date');
            $table->string('city');
            $table->string('provenance');
            $table->string('country');
            $table->string('pseudo');
            $table->boolean('status')->default(true);
            $table->string('bill_url');
            $table->timestamps();
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('parish_id')->references('id')->on('parishs');
            $table->foreign('input_id')->references('id')->on('inputs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_uutypes');
    }
}
