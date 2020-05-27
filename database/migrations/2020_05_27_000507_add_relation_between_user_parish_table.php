<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationBetweenUserParishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_parishs', function (Blueprint $table) {
            //
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('parish_id');
            $table->date('happen_date');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::table('userparishs', function (Blueprint $table) {
            //
        });
    }
}
