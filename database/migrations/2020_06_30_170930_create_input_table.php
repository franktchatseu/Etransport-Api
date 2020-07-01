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
            $table->unsignedBigInteger('user_utype_id')->nullable();
            $table->unsignedBigInteger('pattern_donation_id')->nullable();
            $table->unsignedBigInteger('parish_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('nature_id');
            $table->date('date')->nullable();
            $table->string('city');
            $table->string('provenance');
            $table->string('reference');
            $table->string('country');
            $table->string('pseudo')->nullable();
            $table->boolean('status')->default(0);
            $table->string('bill_url');
            $table->double('amount')->nullable();
            $table->text('description')->nullable();
            $table->string('reason');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
            $table->foreign('pattern_donation_id')->references('id')->on('pattern_donations');
            $table->foreign('parish_id')->references('id')->on('parishs');
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
