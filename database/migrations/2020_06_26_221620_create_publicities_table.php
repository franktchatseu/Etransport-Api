<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('photos');
            $table->integer('priority')->nullable()->default(0);
            $table->integer('view_numbers')->nullable()->default(0);
            $table->integer('click_numbers')->nullable()->default(0);
            $table->date('date_end');
            $table->text('description')->nullable();
            $table->string('link', 255)->nullable();
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
        Schema::dropIfExists('publicities');
    }
}
