<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualmemberAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annualmember_authorizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('annualmember_id');
            $table->unsignedBigInteger('authorization_id');
            $table->date('date');
            $table->enum('status',['PENDING','REJECTED','ACCEPTED']);
            $table->timestamps();
            //$table->foreign('annualmember_id')->references('id')->on('annual_members');
            //$table->foreign('authorization_id')->references('id')->on('authorizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_transferts');
    }
}
