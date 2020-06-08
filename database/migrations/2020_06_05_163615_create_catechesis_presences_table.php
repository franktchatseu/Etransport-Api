<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatechesisPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catechesis_presences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plug_id');
            $table->unsignedBigInteger('user_catechesis_id');
            $table->timestamps();
            $table->foreign('plug_id')->references('id')->on('plugs');
            $table->foreign('user_catechesis_id')->references('id')->on('catechesis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catechesis_presences');
    }
}
