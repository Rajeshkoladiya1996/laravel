<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStreamIdToBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('battles', function (Blueprint $table) {
             
             $table->string('stream_id')->nullable()->after('status');
             $table->enum('is_win',array('0','1','2','3'))->default('0')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('battles', function (Blueprint $table) {

            $table->string('stream_id')->nullable();
            $table->enum('is_win',array('0','1','2','3'))->default('0');

        });
    }
}
