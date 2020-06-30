<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiturgicaltextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liturgical_texts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_entry_type_id');
            $table->unsignedBigInteger('parish_id');
            $table->string('title');
            $table->string('contenu');
            $table->string('image')->nullable();

            $table->foreign('type_entry_type_id')->references('id')->on('liturgical_type_entry_types')->onDelete('cascade');
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
        Schema::dropIfExists('liturgical_texts');
    }
}
