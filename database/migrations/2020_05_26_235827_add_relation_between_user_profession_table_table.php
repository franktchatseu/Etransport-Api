<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationBetweenUserProfessionTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profressions', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_utype_id');
            $table->unsignedBigInteger('profession_id');
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('profession_id')->references('id')->on('professions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userprofressions', function (Blueprint $table) {
            //
        });
    }
}
