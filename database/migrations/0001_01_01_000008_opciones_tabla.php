<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta la migración para crear la tabla opciones
     */
    public function up(): void
    {
        Schema::create('opciones', function (Blueprint $table) {
            $table->id();
            $table->text('opcion');
            $table->boolean('es_correcta')->default(false);
            // Se establece la clave foránea con la tabla preguntas
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opciones');
    }
};
