<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGemsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gems_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('gift_id');
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade')->onUpdate('cascade');
            $table->double('gems');
            $table->integer('qty');
            $table->integer('spend_qty')->default(0);
            $table->boolean('status')->default(1)->commnet('1. Active/ 0.deactive');
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
        Schema::dropIfExists('user_gems_details');
    }
}
