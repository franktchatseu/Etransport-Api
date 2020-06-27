<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('inputs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->double('amount');
                $table->text('description')->nullable();
                $table->string('reason');
                $table->date('start_date');
                $table->date('end_date');
                $table->unsignedBigInteger('nature_id');
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('nature_id')->references('id')->on('natures')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inputs');
    }
}
