<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdFieldToParishonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parishionals', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_utype_id');
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
        Schema::table('parishionals', function (Blueprint $table) {
            //
        });
    }
}
