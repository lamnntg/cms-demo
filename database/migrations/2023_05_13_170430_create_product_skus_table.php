<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_skus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->string('sku_code');
            $table->double('price');
            $table->integer('quantity')->default(0);
            $table->text('image_sku')->nullable();
            $table->string('material')->nullable();
            $table->string('size')->nullable()->default('S');
            $table->string('color');
            $table->integer('quantity_size_s')->default(0);
            $table->integer('quantity_size_m')->default(0);
            $table->integer('quantity_size_l')->default(0);
            $table->integer('quantity_size_xl')->default(0);
            $table->integer('quantity_size_2xl')->default(0);
            $table->string('description')->nullable();

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
        Schema::dropIfExists('product_skus');
    }
}
