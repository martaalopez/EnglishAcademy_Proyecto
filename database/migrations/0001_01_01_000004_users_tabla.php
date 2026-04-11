<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta la migración para crear la tabla users
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('rol', ['alumno', 'profesor']);
            $table->enum('nivel', ['b1', 'b2', 'c1']);
            $table->unsignedBigInteger('clase_id');
            // Se establece la clave foránea con la tabla clases
            $table->foreign('clase_id')
                ->references('id')
                ->on('clases')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
