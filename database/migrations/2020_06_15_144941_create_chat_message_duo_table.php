<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessageDuoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_message_duos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_discussion_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('sender_delete_at')->nullable();
            $table->timestamp('receiver_delete_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->string('files')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('user_utypes'); // ->onDelete('cascade');
            $table->foreign('chat_discussion_id')->references('id')->on('chat_discussions'); // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_message_duos');
    }
}
