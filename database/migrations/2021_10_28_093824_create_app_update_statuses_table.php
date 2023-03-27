<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUpdateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_update_statuses', function (Blueprint $table) {
            $table->id();
            $table->boolean('device_type')->comment('0. android / 1.iOS');
            $table->string('device_version');
            $table->boolean('update_force')->default(0)->comment('1. True / 0. False');
            $table->string('contant_update_day');
            $table->boolean('is_production')->default(0)->comment('1. True / 0. False');
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
        Schema::dropIfExists('app_update_statuses');
    }
}
