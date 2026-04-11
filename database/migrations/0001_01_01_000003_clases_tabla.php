<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta la migración para crear la tabla clases
     */
    public function up(): void
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->enum('nivel', ['b1', 'b2', 'c1']);
            $table->string('codigo', 20)->unique();
            $table->unsignedBigInteger('profesor_id')->nullable();
            // Se establece la clave foránea con la tabla users
            $table->foreign('profesor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
