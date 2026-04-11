<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'opciones';

    // Campos
    protected $fillable = [
        'opcion',
        'es_correcta',
        'pregunta_id',
    ];

    protected $casts = [
        'es_correcta' => 'boolean',
    ];

    //  Una opción pertenece a una pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    // Obtener solo opciones correctas
    public function scopeCorrecta($query)
    {
        return $query->where('es_correcta', true);
    }

    // Obtener solo opciones incorrectas
    public function scopeIncorrecta($query)
    {
        return $query->where('es_correcta', false);
    }
}
