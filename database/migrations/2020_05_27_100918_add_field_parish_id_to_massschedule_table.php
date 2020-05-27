<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldParishIdToMassscheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mass_shedules', function (Blueprint $table) {
            //
            $table->unsignedInteger('parish_id');
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
        Schema::table('massschedules', function (Blueprint $table) {
            //
        });
    }
}
