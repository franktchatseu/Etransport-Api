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
            $table->string('assisted_person');
            $table->unsignedBigInteger('age');
            $table->enum('gender',['F', 'M']);
            $table->string('quater');
            $table->string('disease_nature');
            $table->boolean('is_baptisted')->default(false);
            $table->string('avatar')->nullable();
            $table->date('request_date'); 
            $table->text('comment');
            $table->unsignedBigInteger('person_id');
            $table->enum('status',['REJECTED','PENDING','ACCEPTED']);
            
            $table->foreign('person_id')->references('id')->on('user_utypes')->onDelete('cascade');
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
