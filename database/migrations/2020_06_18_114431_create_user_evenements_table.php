<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_evenements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_utype_id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_evenements');
    }
}
