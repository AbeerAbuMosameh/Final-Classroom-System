<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles_and_permissions_tables', function (Blueprint $table) {
            Schema::table('roles', function (Blueprint $table) {
                $table->enum('level', ['teacher','student'])->default('student');
            });

            Schema::table('permissions', function (Blueprint $table) {
                $table->enum('level', ['teacher','student'])->default('student');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('level');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
