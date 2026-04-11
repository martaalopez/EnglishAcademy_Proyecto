<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    // Se definen los campos
    protected $fillable = [
        'user_id',
        'cuestionario_id',
        'puntuacion_obtenida',
        'respuestas',
    ];

    protected $casts = [
        'puntuacion_obtenida' => 'integer',
        'respuestas' => 'array',
    ];

    /**
     * Se obtiene el usuario que realizó el resultado
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Se obtiene el cuestionario del resultado
     */
    public function cuestionario()
    {
        return $this->belongsTo(Cuestionario::class);
    }

    /**
     * Se filtran los resultados de un usuario específico
     */
    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Se filtran los resultados de un cuestionario específico
     */
    public function scopeDeCuestionario($query, $cuestionarioId)
    {
        return $query->where('cuestionario_id', $cuestionarioId);
    }
}
