<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordofpriestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wordofpriests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('contenu');
            $table->string('picture_priest');
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
        Schema::dropIfExists('wordofpriests');
    }
}
