<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleAttributeMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_attribute_menus', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('attribute_menu_id');
            $table->text('value');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');;
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');;
            $table->foreign('attribute_menu_id')->references('id')->on('attribute_menus')->onDelete('cascade');;
            //$table->primary(['article_id', 'attribute_menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_attribute_menus');
    }
}
