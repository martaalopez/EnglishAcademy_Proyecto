<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    // Se definen los campos
    protected $fillable = [
        'pregunta',
        'audio',
        'cuestionario_id',
    ];

    /**
     * Se obtiene el cuestionario al que pertenece la pregunta
     */
    public function cuestionario()
    {
        return $this->belongsTo(Cuestionario::class);
    }

    /**
     * Se obtienen todas las opciones de la pregunta
     */
    public function opciones()
    {
        return $this->hasMany(Opcion::class);
    }

    /**
     * Se obtiene la opción correcta de la pregunta
     */
    public function opcionCorrecta()
    {
        return $this->hasOne(Opcion::class)->where('es_correcta', true);
    }

    /**
     * Se filtran las preguntas que tienen audio
     */
    public function scopeConAudio($query)
    {
        return $query->whereNotNull('audio');
    }
}
