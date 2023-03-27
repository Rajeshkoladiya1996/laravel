<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('to_id');
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('live_stream_id')->nullable();
            $table->foreign('live_stream_id')->references('id')->on('live_stream_users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('battle_id')->nullable();
            $table->foreign('battle_id')->references('id')->on('battles')->onDelete('cascade')->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->longText('message_detail')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('user_chats');
    }
}
