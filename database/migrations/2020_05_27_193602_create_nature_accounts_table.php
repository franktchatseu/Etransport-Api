<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNatureAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nature_accounts', function (Blueprint $table) {
            $table->inxrements('id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('nature_id');
            $table->timestamps();

            /* $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('nature_id')->references('id')->on('natures'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nature_accounts');
    }
}
