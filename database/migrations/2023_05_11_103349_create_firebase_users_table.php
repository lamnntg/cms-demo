<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirebaseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firebase_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uid');
            $table->string('email')->unique();
            $table->string('display_name')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('local_id')->nullable();
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
        Schema::dropIfExists('firebase_users');
    }
}
