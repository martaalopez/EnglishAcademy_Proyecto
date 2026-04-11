<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta la migración para crear la tabla mensajes
     */
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('mensaje');
            $table->unsignedBigInteger('clase_id');
            // Se establece la clave foránea con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            // Se establece la clave foránea con la tabla clases
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
