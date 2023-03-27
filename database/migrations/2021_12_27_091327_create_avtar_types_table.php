<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvtarTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avtar_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('avtar_type')->default(1)->comment('1. Male/ 0. Female');
            $table->string('image')->default('default.png');
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('avtar_types');
    }
}
