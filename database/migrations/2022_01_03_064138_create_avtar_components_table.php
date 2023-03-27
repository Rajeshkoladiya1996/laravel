<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvtarComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avtar_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('avtartype_id')->nullable();
            $table->foreign('avtartype_id')->references('id')->on('avtar_types')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('avtar_cat_id')->nullable();
            $table->foreign('avtar_cat_id')->references('id')->on('avtar_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image')->nullable();
            $table->string('iscolor')->nullable();
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
        Schema::dropIfExists('avtar_components');
    }
}
