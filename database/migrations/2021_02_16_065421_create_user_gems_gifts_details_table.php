<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGemsGiftsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gems_gifts_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_gems_id');
            $table->foreign('user_gems_id')->references('id')->on('user_gems_details')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('gift_id');
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade')->onUpdate('cascade');
            $table->double('qty');
            $table->double('amount');
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
        Schema::dropIfExists('user_gems_gifts_details');
    }
}
