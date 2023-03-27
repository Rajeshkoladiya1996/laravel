<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGiftIdColumnToUserSpendGemsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_spend_gems_details', function (Blueprint $table) {
            // $table->unsignedBigInteger('gift_id')->nullable()->after('to_id');
            // $table->foreign('gift_id')->references('id')->on('gifts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_spend_gems_details', function (Blueprint $table) {
            Schema::dropIfExists('gift_id');
        });
    }
}
