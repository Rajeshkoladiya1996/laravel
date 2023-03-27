<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendGiftDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spend_gift_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spend_id');
            $table->foreign('spend_id')->references('id')->on('user_spend_gems_details')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('gift_id');
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade')->onUpdate('cascade');
            $table->double('gems');
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
        Schema::dropIfExists('spend_gift_details');
    }
}
