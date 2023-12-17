<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('slug')->unique();
            $table->integer('views')->default(0);
            $table->text('images')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('news');
    }
}
