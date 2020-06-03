<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('natures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->enum('status', ['ELEVE', 'ETUDIANT', 'HOMME', 'FEMME']);
            $table->double('amount');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('inputs', function (Blueprint $table) {
            $table->unsignedBigInteger('nature_id');
            $table->foreign('nature_id')->references('id')->on('natures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nature');
    }
}
