<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCathedralPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cathedral_presences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plug_id');
            $table->unsignedBigInteger('cathechesis_id');
            $table->unsignedBigInteger('annual_member_id');
            $table->date('date_days');
            $table->timestamps();
            $table->foreign('plug_id')->references('id')->on('plugs');
            $table->foreign('cathechesis_id')->references('id')->on('catechesis');
            // $table->foreign('annual_member_id')->references('id')->on('annual_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cathedral_presences');
    }
}
