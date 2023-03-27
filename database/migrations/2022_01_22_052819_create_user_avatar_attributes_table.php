<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAvatarAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_avatar_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_avatar_id');
            $table->foreign('user_avatar_id')->references('id')->on('user_avatars')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('avatar_component_id');
            $table->foreign('avatar_component_id')->references('id')->on('avtar_components')->onDelete('cascade')->onUpdate('cascade');
            $table->string('amount');
            $table->unsignedBigInteger('send_user_id');
            $table->foreign('send_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type');
            $table->boolean('is_use')->default(0)->comment('1. yes / 0. no');
            $table->boolean('status')->default(1)->comment('1. active / 0. deactive');
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
        Schema::dropIfExists('user_avatar_attributes');
    }
}
