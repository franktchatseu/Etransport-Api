<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMemberGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_member_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['NOT_YET', 'ACCEPTED', 'REJECTED']);
            $table->unsignedBigInteger('chat_group_id');
            $table->unsignedBigInteger('user_utype_id');

            $table->foreign('chat_group_id')->references('id')->on('chat_groups');
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
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
        Schema::dropIfExists('chat_member_groups');
    }
}
