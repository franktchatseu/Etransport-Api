<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationBetweenPatternPlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugs', function (Blueprint $table) {
            $table->unsignedBigInteger('pattern_id');
            $table->foreign('pattern_id')->references('id')->on('patterns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patternplugs', function (Blueprint $table) {
            //
        });
    }
}
