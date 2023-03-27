<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->longText('password')->nullable();
            $table->string('stream_id')->nullable();
            $table->string('county_code')->nullable();
            $table->string('bod')->nullable();
            $table->boolean('gender')->default(1)->comment('1. Male/ 0. Female');
            $table->string('profile_pic')->default('default.png');
            $table->string('login_type')->nullable()->comment('phone/email/facebook/google/apple');
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->longText('social_pic')->nullable();
            $table->longText('device_token')->nullable();
            $table->longText('device_id')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->string('otp',6)->nullable();
            $table->boolean('user_type')->comment('1. stream, 0. viewer')->nullable();
            $table->boolean('is_verified')->default(0)->comment('1. varifiy, 0. not varifiy');
            $table->boolean('device_type')->default(1)->comment('0. android / 1.iOS');
            $table->boolean('is_active')->default(1)->comment('1. active / 0. deactive');
            $table->boolean('is_online')->default(0)->comment('1. on / 0. off');
            $table->boolean('is_accept_terms')->default(1)->comment('1. accept / 0. reject');
            $table->timestamp('logindate')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
