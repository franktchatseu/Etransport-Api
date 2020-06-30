<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('titre');
            $table->text('logo');
            $table->date('date_agenda');
            $table->time('heure');
            $table->text('porteur');
            $table->text('activite');
            $table->text('lieu');
            $table->text('concerne');
            $table->unsignedBigInteger('parish_id');
            $table->foreign('parish_id')->references('id')->on('parishs')->onDelete('cascade');
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
        Schema::dropIfExists('agendas');
    }
}
