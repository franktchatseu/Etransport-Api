<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessageGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_message_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('group_id');
            $table->string('sender_name');
            $table->string('files')->nullable();
            $table->text('message')->nullable();
            $table->String('images')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('chat_member_groups');
            $table->foreign('group_id')->references('id')->on('chat_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_message_groups');
    }
}
