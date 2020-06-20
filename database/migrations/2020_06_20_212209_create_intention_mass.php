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
        Schema::create('intention_masss', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('request_date');
            $table->date('intention');
            $table->unsignedBigInteger('ammount');
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
        Schema::dropIfExists('intention_masss');
    }
}
