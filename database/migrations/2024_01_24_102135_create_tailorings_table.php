<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTailoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tailorings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('style')->nullable();
            $table->string('bust')->nullable();
            $table->string('waist')->nullable();
            $table->string('hips')->nullable();
            $table->string('height')->nullable();
            $table->string('unit')->nullable()->default('cm');
            $table->string('size_convert')->nullable();
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
        Schema::dropIfExists('tailorings');
    }
}
