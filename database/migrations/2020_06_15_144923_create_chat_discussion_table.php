<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatDiscussionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_discussions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_utype1_id');
            $table->unsignedBigInteger('user_utype2_id');
            $table->text('last_message')->nullable();
            $table->timestamps();

            // contraintes 
            $table->foreign('user_utype1_id')->references('id')->on('user_utypes');
            $table->foreign('user_utype2_id')->references('id')->on('user_utypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_discussions');
    }
}
