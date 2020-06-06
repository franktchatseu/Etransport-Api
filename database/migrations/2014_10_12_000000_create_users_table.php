<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->date('birth_place')->nullable();
            $table->string('avatar')->nullable();
            $table->date('baptist_date')->nullable();
            $table->string('baptist_place')->nullable();
            $table->string('language');
            $table->string('state')->nullable();
            $table->string('tel')->nullable();
            $table->enum('gender',['F', 'M']);

            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('utypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('value', ['PRIEST', 'CATECHIST', 'CATECHUMEN', 'PARISHIONAL', 'OTHER']);
            $table->timestamps();
        });

        Schema::create('user_utypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('type_id');
            $table->boolean('is_active')->default(true);


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('utypes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
