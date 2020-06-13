<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sanctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_utype_id');
            $table->unsignedBigInteger('sanction_id');
            $table->string('reason');
            $table->timestamps();
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('sanction_id')->references('id')->on('sanctions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sanctions');
    }
}
