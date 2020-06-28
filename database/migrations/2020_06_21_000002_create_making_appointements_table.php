<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakingAppointementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('making_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->time('request_hour');
            $table->date('request_date');
            $table->text('request_comment');
            $table->enum('state',['PENDING', 'APPROVED', 'REJECTED']);
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('person_id');

            $table->foreign('person_id')->references('id')->on('user_utypes')->onDelete('cascade');
            $table->foreign('object_id')->references('id')->on('object_making_appointments')->onDelete('cascade');
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
        Schema::dropIfExists('making_appointments');
    }
}
