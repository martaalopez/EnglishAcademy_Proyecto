<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    use HasFactory;

    // Se definen los campos 
    protected $fillable = [
        'titulo',
        'descripcion',
        'clase_id',
        'profesor_id',
        'tipo',
    ];

    /** Se obtiene el profesor que creó el cuestionario*/
    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }
    /** Se obtiene la clase a la que pertenece el cuestionario */
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }
    /**Se obtienen todas las preguntas del cuestionario*/
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
}
