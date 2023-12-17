<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('slug')->unique();
            $table->integer('views')->default(0);
            $table->text('images')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->double('price')->nullable();
            $table->tinyInteger('status')->default(2)->comment('0. reject, 1. accept, 2. waiting');
            $table->float('area')->nullable()->comment('m2');
            $table->smallInteger('bedrooms')->default(0);
            $table->smallInteger('wcs')->default(0);
            $table->smallInteger('livingrooms')->nullable()->default(0);
            $table->text('address')->nullable();
            $table->text('direction_house')->nullable();
            $table->string('house_number')->nullable();
            $table->tinyInteger('kind')->default(0);
            $table->text('hashtags')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // index
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('house_articles');
    }
}
