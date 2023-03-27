<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('slug');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('terms_condition')->nullable()->after('end_date');
            $table->string('thai_terms_condition')->nullable()->after('terms_condition');
            $table->string('stream_type')->nullable()->after('thai_terms_condition');
            $table->string('reward_type')->nullable()->after('stream_type');
            $table->unsignedBigInteger('gift_category_id')->nullable()->after('reward_type');
            $table->foreign('gift_category_id')->references('id')->on('gift_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('primary_color')->nullable()->after('gift_category_id');
            $table->string('secondry_color')->nullable()->after('primary_color');
            $table->boolean('isGradient')->default(0)->comment('1. true / 0. false')->after('secondry_color');
            $table->string('start_gradient')->nullable()->after('isGradient');
            $table->string('end_gradient')->nullable()->after('start_gradient');
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
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('terms_condition');
            $table->dropColumn('thai_terms_condition');
            $table->dropColumn('stream_type');
            $table->dropColumn('reward_type');
            $table->dropColumn('gift_category_id');
            $table->dropColumn('primary_color');
            $table->dropColumn('secondry_color');
            $table->dropColumn('isGradient');
            $table->dropColumn('start_gradient');
            $table->dropColumn('end_gradient');
        });
    }
}
