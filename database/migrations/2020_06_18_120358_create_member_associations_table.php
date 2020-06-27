<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('raisonAdhesion');
            $table->date('date_adhesion');
            $table->enum('status',['PENDING','REJECTED','ACCEPTED']);

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
        Schema::dropIfExists('member_associations');
    }
}
