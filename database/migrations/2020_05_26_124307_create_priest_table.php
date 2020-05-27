<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priests', function (Blueprint $table) {
            $table->increments('id');
            $table->date('ordination_date')->nullable();
            $table->text('ordination_place');
            $table->text('ordination_godfather');
            $table->text('career');
            $table->unsignedInteger('parish_id');
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
        Schema::dropIfExists('priests');
    }
}
