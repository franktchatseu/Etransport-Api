<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('mission_order_id')->unsigned();
            $table->integer('transport_element_id')->unsigned();
            $table->string('loading_city')->nullable();
            $table->string('product')->nullable();
            $table->string('quantity')->nullable();
            $table->string('voucher_number')->nullable();
            $table->string('park_observation')->nullable();
            $table->string('field_observation')->nullable();
            $table->foreign('mission_order_id')->references('id')->on('mission_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('transport_element_id')->references('id')->on('transport_elements')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cargos');
    }
}
