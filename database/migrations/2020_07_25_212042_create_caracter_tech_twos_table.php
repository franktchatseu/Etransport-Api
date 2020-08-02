<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaracterTechTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracter_tech_twos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('semi_trailer_number');
            $table->unsignedBigInteger('stepper_id');
            $table->Integer('essieux_tracteur_porteur_number');
            $table->Integer('place_nber');
            $table->string('interne_code');
            $table->date('effective_date');
            $table->text('fuel');
            $table->String('color');
            $table->text('option');
            $table->double('purchase_value');
            $table->double('kilometrage');
            $table->double('consommation_min');
            $table->double('consommation_max');
            $table->text('etat');
            $table->foreign('stepper_id')->references('id')->on('stepper_trees')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracter_tech_twos');
    }
}
