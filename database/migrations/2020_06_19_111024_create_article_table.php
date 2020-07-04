<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->text('titre');
            $table->string('date_de_publication');
            $table->text('contenu_1')->nullable();
            $table->text('contenu_2')->nullable();
            $table->text('fichier')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parish_id');
            $table->unsignedBigInteger('sub_menu_id');
            $table->timestamps();
            $table->foreign('sub_menu_id')->references('id')->on('sub_menus')->onDelete('cascade');
            $table->foreign('parish_id')->references('id')->on('parishs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user_utypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
