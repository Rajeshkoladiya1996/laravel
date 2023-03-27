<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventTypeAndGiftidInEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('gift_id')->nullable()->after('gift_category_id');
            $table->string('event_type')->nullable()->after('reward_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('gift_id')->nullable()->after('gift_category_id');
            $table->string('event_type')->nullable()->after('reward_type');
        });
    }
}
