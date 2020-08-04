<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocIndentityInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_indentity_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identical_piece');
            $table->string('piece_number');
            $table->date('date_issue');
            $table->string('place_issue');
            $table->unsignedBigInteger('stepper_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('stepper_id')->references('id')->on('stepper_drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_indentity_informations');
    }
}
