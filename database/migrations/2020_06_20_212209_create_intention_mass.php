<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntentionMass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intention_masses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('request_date');
            $table->date('intention');
            $table->text('content')->nullable();
            $table->string('photo');
            $table->unsignedBigInteger('ammount');
            $table->enum('status',['REJECTED','PENDING','ACCEPTED']);
            $table->unsignedBigInteger('person_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('person_id')->references('id')->on('user_utypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intention_masss');
    }
}
