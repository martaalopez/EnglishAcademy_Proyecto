<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // USERS → CLASES
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('clase_id')
                ->references('id')
                ->on('clases')
                ->nullOnDelete();
        });

        // CLASES → USERS (profesor)
        Schema::table('clases', function (Blueprint $table) {
            $table->foreign('profesor_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clase_id']);
        });

        Schema::table('clases', function (Blueprint $table) {
            $table->dropForeign(['profesor_id']);
        });
    }
};
