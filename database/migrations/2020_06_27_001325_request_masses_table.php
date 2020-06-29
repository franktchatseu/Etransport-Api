<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequestMassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_masses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hour');
            $table->date('date');
            $table->string('place');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('amount');
            $table->enum('status',['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('priest_id');

            $table->foreign('priest_id')->references('id')->on('user_utypes')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('user_utypes')->onDelete('cascade');
            $table->foreign('object_id')->references('id')->on('object_request_masses')->onDelete('cascade');
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
        Schema::dropIfExists('request_masses');
    }
}
