<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function alumno()
    {
        // Se coge el usuario que está autenticado
        $user = Auth::user();

        // Se obtiene la clase a la que pertenece el usuario
        $clase = $user->clase;

        // Si tiene clase, se obtienen sus cuestionarios
        $cuestionarios = $clase ? $clase->cuestionarios : collect();

        // Se envían los datos a la vista del alumno
        return view('dashboard.alumno', [
            'user' => $user,
            'clase' => $clase,
            'cuestionarios' => $cuestionarios,
        ]);
    }

    public function profesor()
    {
        // Se obtiene el usuario que está autenticado
        $user = Auth::user();

        // Se obtiene la clase asociada al profesor
        $clase = $user->clase;

        // Si existe clase, se obtienen sus cuestionarios
        $cuestionarios = $clase ? $clase->cuestionarios : collect();

        // Se envían los datos a la vista del profesor
        return view('dashboard.profesor', [
            'user' => $user,
            'clase' => $clase,
            'cuestionarios' => $cuestionarios,
        ]);
    }
}
