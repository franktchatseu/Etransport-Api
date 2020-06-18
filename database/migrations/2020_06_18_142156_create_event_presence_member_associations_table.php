<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPresenceMemberAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_presence_member_associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('isPresence');
            $table->unsignedBigInteger('evenement_id');
            $table->unsignedBigInteger('member_association_id');
            
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
        Schema::dropIfExists('event_presence_member_associations');
    }
}
