<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProgramme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('jour',['LUNDI','MARDI','MERCREDI','JEUDI','VENDREDI','SAMEDI','DIMANCHE']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->text('description');
            $table->text('contact');
            $table->enum('type',['REGULIER','IRREGULIER']);
            $table->date('date_planifiee');
            $table->unsignedBigInteger('parish_id');
            $table->foreign('parish_id')->references('id')->on('parishs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_programme');
    }
}
