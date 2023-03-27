<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoRewardEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_event', function (Blueprint $table) {
            $table->string('frame_file')->after('thai_description')->nullable();
            $table->integer('frame_days')->after('frame_file')->nullable();
            $table->unsignedBigInteger('gift_id')->after('frame_days')->nullable();
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('win_reward_type')->after('gift_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_event', function (Blueprint $table) {

        });
    }
}
