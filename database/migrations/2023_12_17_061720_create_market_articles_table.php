<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('slug')->unique();
            $table->integer('views')->default(0);
            $table->text('images')->nullable();
            $table->double('price')->nullable();
            $table->tinyInteger('status')->default(2)->comment('0. reject, 1. accept, 2. waiting');
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
        Schema::dropIfExists('market_articles');
    }
}
