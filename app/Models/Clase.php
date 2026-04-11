<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    // Se definen los campos
    protected $fillable = [
        'nombre',
        'nivel',
        'codigo',
        'profesor_id',
    ];

    /**
     * Se obtiene el profesor que pertenece a esta clase
     */
    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    /**
     * Se obtienen todos los alumnos de esta clase
     */
    public function alumnos()
    {
        return $this->hasMany(User::class, 'clase_id');
    }

    /**
     * Se obtienen todos los mensajes de esta clase
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    /**
     * Se obtienen todos los cuestionarios de esta clase
     */
    public function cuestionarios()
    {
        return $this->hasMany(Cuestionario::class, 'clase_id');
    }

    /**
     * Se obtienen todos los participantes (profesor y alumnos) de esta clase
     */
    public function participantes()
    {
        return [
            'profesor' => $this->profesor,
            'alumnos' => $this->alumnos,
        ];
    }
}
