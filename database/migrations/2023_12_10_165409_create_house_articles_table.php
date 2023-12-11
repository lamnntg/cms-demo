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
            $table->text('content')->nullable();
            $table->string('slug')->unique();
            $table->integer('views')->default(0);
            $table->text('images')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->double('price')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->float('area')->nullable();
            $table->smallInteger('bedrooms')->default(0);
            $table->smallInteger('wcs')->default(0);
            $table->smallInteger('livingrooms')->default(0);
            $table->text('address')->nullable();
            $table->text('direction_house')->nullable();
            $table->smallInteger('house_number')->nullable();
            $table->tinyInteger('kind')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
