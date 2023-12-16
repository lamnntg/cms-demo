<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleInFirebaseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firebase_users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('local_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('firebase_users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
