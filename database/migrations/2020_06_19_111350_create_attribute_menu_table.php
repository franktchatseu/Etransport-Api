<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('sub_menu_id');
            $table->boolean('is_required')->default(1);
            $table->unsignedSmallInteger('min_length')->nullable();
            $table->unsignedSmallInteger('max_length')->nullable();

            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');;
            $table->foreign('sub_menu_id')->references('id')->on('sub_menus')->onDelete('cascade');;
            $table->unique(['attribute_id', 'sub_menu_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_menus');
    }
}
