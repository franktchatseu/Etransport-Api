<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldParishIdToAlbumTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parish_albums', function (Blueprint $table) {
            //
            $table->unsignedInteger('album_id');
            $table->unsignedInteger('parish_id');
            $table->date('happen_date');
            $table->foreign('album_id')->references('id')->on('albums');
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
        Schema::table('parishalbums', function (Blueprint $table) {
            //
        });
    }
}
