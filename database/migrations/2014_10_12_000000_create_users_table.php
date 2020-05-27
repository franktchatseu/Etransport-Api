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
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->date('birth_place')->nullable();
            $table->string('avatar')->nullable();
            $table->date('basptist_date')->nullable();
            $table->string('basptist_place')->nullable();
            $table->string('language');
            $table->string('state')->nullable();
            $table->string('tel')->nullable();
            $table->enum('user_type', ['PRIEST', 'CATECHIST', 'CATECHUMEN', 'PARISHIONER', 'OTHER']);
            $table->enum('gender',['F', 'M']);

            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
