<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_inputs', function (Blueprint $table) {
                $table->unsignedInteger('user_id');
               // $table->unsignedInteger('input_id');
                $table->unsignedInteger('transaction_id');
                $table->unsignedInteger('amount');
                $table->date('date');
                $table->string('city');
                $table->string('provenance');
                $table->string('country');
                $table->string('pseudo');
                $table->foreign('user_id')->references('id')->on('users');
               // $table->foreign('input_id')->references('id')->on('inputs');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_inputs', function (Blueprint $table) {
            //
        });
    }
}
