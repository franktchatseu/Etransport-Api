<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('report_problems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('utype_id');
            $table->string('nature')->nullable();
            $table->string('concerne');
            $table->text('details')->nullable();
            $table->string('image')->nullable();
            $table->enum('state', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('utype_id')->references('id')->on('utypes')
                ->onDelete('cascade')->onUpdate('cascade') ; 
        });
    }

    /**utypes
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_problems');
    }
}