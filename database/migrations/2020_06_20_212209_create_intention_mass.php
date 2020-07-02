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
            $table->date('date');
            $table->text('intention');
            $table->text('content')->nullable();
            $table->unsignedBigInteger('mass_id');
            $table->unsignedBigInteger('amount');
            $table->enum('status',['REJECTED','PENDING','ACCEPTED'])->default('REJECTED');
            $table->unsignedBigInteger('person_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('person_id')->references('id')->on('user_utypes')->onDelete('cascade');
            $table->foreign('mass_id')->references('id')->on('mass_shedules')->onDelete('cascade');
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
