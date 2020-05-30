<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationBetweenUserSacramentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sacraments', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sacrament_id');
            $table->date('taken_date');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('sacrament_id')->references('id')->on('sacraments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usersacraments', function (Blueprint $table) {
            //
        });
    }
}
