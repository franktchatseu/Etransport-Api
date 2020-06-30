<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('parish_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slogan')->nullable();
            $table->text('description')->nullable();
            $table->string('lieu')->nullable();
            $table->text('rencontre')->nullable();
            $table->date('dateCreation')->nullable();
            $table->string('reglement')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('type_id')->references('id')->on('type_associations')->onDelete('cascade');
            $table->foreign('parish_id')->references('id')->on('parishs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('associations');
    }
}
