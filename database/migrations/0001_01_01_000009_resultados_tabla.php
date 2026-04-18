<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta la migración para crear la tabla resultados
     */
    public function up(): void
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            // Se establece la clave foránea con la tabla users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Se establece la clave foránea con la tabla cuestionarios
            $table->foreignId('cuestionario_id')->constrained('cuestionarios')->onDelete('cascade');
            $table->integer('puntuacion_obtenida')->default(0);
            // Se guardan las respuestas en formato JSON
            $table->json('respuestas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
