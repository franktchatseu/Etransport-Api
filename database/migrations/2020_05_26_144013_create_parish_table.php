<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parish', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name');
            $table->string('location');
            $table->string('curé');
            $table->string('creation_decision');
            $table->string('mass_horary');
            $table->string('confession_days');
            $table->string('confession_horary');
            $table->date('saint_patron_date');
            $table->string('priest_list');
            $table->integer('parish_structures');
            $table->integer('pastoral_services');
            $table->integer('number_of_groupes');
            $table->integer('number_of_ceb');
            $table->integer('number_of_post');
            $table->text('patrimony');
            $table->string('contact');
            $table->string('email');
            $table->integer('seminarist_number');
            $table->string('picture')->nullable();
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
        Schema::dropIfExists('parish');
    }
}
