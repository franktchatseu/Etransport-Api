<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->text('documents');
            $table->timestamps();
        });

        Schema::table('annualmember_authorizations', function (Blueprint $table) {
            $table->foreign('annualmember_id')->references('id')->on('annual_members');
            $table->foreign('authorization_id')->references('id')->on('authorizations');
        });

        Schema::table('cathedral_presences', function (Blueprint $table) {
            $table->foreign('annual_member_id')->references('id')->on('annual_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorizations');
    }
}
