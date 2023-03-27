<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComponentIdToAvtarComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avtar_components', function (Blueprint $table) {
            $table->string('component_id')->after('avtar_cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avtar_components', function (Blueprint $table) {
            $table->dropColumn('component_id');
        });
    }
}
