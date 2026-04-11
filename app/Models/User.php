<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Se definen los campos
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'nivel',
        'clase_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Se obtiene la clase a la que pertenece el usuario
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    /**
     * Se obtiene la clase que imparte el usuario
     */
    public function claseImpartida()
    {
        return $this->hasOne(Clase::class, 'profesor_id');
    }

    /**
     * Se obtienen todos los mensajes del usuario
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    /**
     * Se obtienen todos los resultados del usuario
     */
    public function resultados()
    {
        return $this->hasMany(Resultado::class, 'user_id');
    }

    /**
     * Se verifica si el usuario es alumno
     */
    public function isAlumno(): bool
    {
        return $this->rol === 'alumno';
    }

    /**
     * Se verifica si el usuario es profesor
     */
    public function isProfesor(): bool
    {
        return $this->rol === 'profesor';
    }
}
