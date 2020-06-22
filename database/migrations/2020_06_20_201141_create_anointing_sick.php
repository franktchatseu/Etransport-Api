<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnointingSick extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anointing_sicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('good_to_know');
            $table->string('assisted_person');
            $table->unsignedBigInteger('age');
            $table->enum('gender',['F', 'M']);
            $table->string('quater');
            $table->string('disease_nature');
            $table->boolean('is_baptized');
            $table->string('avatar')->nullable();
            $table->date('request_date');
            $table->text('comment');
            $table->enum('status',['REJECTED','PENDING','ACCEPTED']);
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
        Schema::dropIfExists('anointing_sicks');
    }
}
