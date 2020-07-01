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
            $table->unsignedBigInteger('person_id');
            $table->text('nature');
            $table->text('concern');
            $table->text('details');
            $table->string('image')->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('user_utypes')
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
