<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationBetweenParishParishpatrimoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parish_patrimonies', function (Blueprint $table) {
            //
            $table->unsignedInteger('parish_id');
            $table->date('happen_date');
            $table->foreign('parish_id')->references('id')->on('parishes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parishparishpatrimonys', function (Blueprint $table) {
            //
        });
    }
}
