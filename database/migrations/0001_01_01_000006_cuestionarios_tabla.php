<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta la migración para crear la tabla cuestionarios
     */
    public function up(): void
    {
        Schema::create('cuestionarios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            // Se establece la clave foránea con la tabla clases
            $table->foreignId('clase_id')->constrained('clases')->onDelete('cascade');
            // Se establece la clave foránea con la tabla users
            $table->foreignId('profesor_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['gramatica', 'vocabulario', 'listening', 'reading']);
            $table->timestamps();
        });
    }

    /**
     * Se revierte la migración eliminando la tabla cuestionarios
     */
    public function down(): void
    {
        Schema::dropIfExists('cuestionarios');
    }
};
