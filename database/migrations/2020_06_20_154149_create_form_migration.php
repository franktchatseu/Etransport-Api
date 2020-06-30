<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_migration', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_utype_id');
            $table->string('reason');
            $table->string('message');
            $table->string('piece')->nullable();
            $table->enum('status',['PENDING','REJECTED','ACCEPTED']);
            $table->timestamps();
            $table->softDeletes();

            // contraintes

            $table->foreign('user_utype_id')->references('id')->on('user_utypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_migration');
    }
}
