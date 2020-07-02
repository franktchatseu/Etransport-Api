<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParishThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parish_themes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('contenu');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('parish_id');
            $table->foreign('parish_id')->references('id')->on('parishs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parish_themes');
    }
}
