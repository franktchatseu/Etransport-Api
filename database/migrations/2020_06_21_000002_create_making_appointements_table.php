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
            $table->string('hour');
            $table->date('date');
            $table->text('comment')->nullable();
            $table->enum('status',['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('person_id');

            $table->foreign('person_id')->references('id')->on('user_utypes')->onDelete('cascade');
            $table->foreign('object_id')->references('id')->on('object_making_appointments')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('intention_masses', function (Blueprint $table) {
            $table->unsignedBigInteger('object_id');
            $table->foreign('object_id')->references('id')->on('object_making_appointments')->onDelete('cascade');
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
