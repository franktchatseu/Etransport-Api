<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportelementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id');
            $table->string('name');
            $table->text('description');
            $table->string('localisation')->nullable();
            $table->string('phone1');
            $table->string('phone2');
            $table->string('email');
            $table->string('function');
            $table->string('presentation_file');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_id')->references('id')->on('actor_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport_elements');
    }
}
