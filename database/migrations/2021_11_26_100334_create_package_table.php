<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->bigInteger('salmon_coin');
            $table->string('image')->nullable();
            $table->string('ios_product_id')->nullable();
            $table->string('android_product_id')->nullable();
            $table->double('price',8,2)->nullable();
            $table->boolean('ios_is_active')->default(0)->comment('1. active / 0. deactive');
            $table->boolean('android_is_active')->default(0)->comment('1. active / 0. deactive');
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
        Schema::dropIfExists('packages');
    }
}
