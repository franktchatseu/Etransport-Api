<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationBetweenStatutMemberAssociation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_associations', function (Blueprint $table) {
            $table->unsignedBigInteger('statut_id');
            $table->unsignedBigInteger('association_id');
            $table->foreign('statut_id')->references('id')->on('statuts')->onDelete('cascade');
            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}