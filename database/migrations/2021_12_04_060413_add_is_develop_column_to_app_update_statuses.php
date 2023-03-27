<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDevelopColumnToAppUpdateStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_update_statuses', function (Blueprint $table) {
            $table->boolean('is_develop')->default(0)->comment('1. True / 0. False')->after('is_festival');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_update_statuses', function (Blueprint $table) {
            $table->dropColumn('is_develop');
        });
    }
}
