<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateEventParticipantDetailsTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_participant_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_participant_id')->nullable();
            $table->foreign('event_participant_id')->references('id')->on('event_participants')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('gift_id')->nullable();
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('live_stream_id')->nullable();
            $table->foreign('live_stream_id')->references('id')->on('live_stream_users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('points')->default(0);
            $table->boolean('is_active')->default(1)->comment('1. active / 0. deactive');
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
        Schema::dropIfExists('event_participant_details');
    }
}
