<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiturgicaltypeentrytypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liturgical_type_entry_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('entry_type_id')->nullable();

            $table->foreign('type_id')->references('id')->on('liturgical_types')->onDelete('cascade');
            $table->foreign('entry_type_id')->references('id')->on('entry_types')->onDelete('cascade');
           
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
        Schema::dropIfExists('liturgicaltypeentrytypes');
    }
}
