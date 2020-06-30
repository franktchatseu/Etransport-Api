<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdFieldToPriestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('priests', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_utype_id');
            $table->unsignedBigInteger('parish_id');
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('parish_id')->references('id')->on('parishs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('priests', function (Blueprint $table) {
            //
        });
    }
}
