<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRewardActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reward_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_daily_rewards_id');
            $table->foreign('user_daily_rewards_id')->references('id')->on('user_daily_rewards')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('action_id')->comment('id of user');
            $table->foreign('action_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type');
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
        Schema::dropIfExists('user_reward_actions');
    }
}
