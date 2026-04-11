<?php

namespace App\Http\Controllers;

use App\Models\Opcion;
use App\Models\Resultado;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultadoController extends Controller
{
    /**
     * Se muestran todos los resultados del usuario
     */
    public function index(): Renderable
    {
        $resultados = Auth::user()->resultados()->get();

        return view('resultados.index', compact('resultados'));
    }

    /**
     * Se muestran todos los resultados de todos los usuarios
     */
    public function showResultados(): Renderable
    {
        if (! Auth::user()->isProfesor()) {
            abort(403);
        }

        $resultados = Resultado::all();

        return view('resultados.showResultados', compact('resultados'));
    }

    /**
     * Se muestra el formulario
     */
    public function create(): Renderable {}

    /**
     * Se guarda un resultado en la base de datos
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cuestionario_id' => 'required|exists:cuestionarios,id',
            'respuestas' => 'required|array',
        ]);

        $puntuacion_obtenida = 0;

        foreach ($request->respuestas as $preguntaId => $opcionId) {
            $opcion = Opcion::find($opcionId);

            if ($opcion && $opcion->es_correcta) {
                $puntuacion_obtenida++;
            }
        }

        $resultado = new Resultado;
        $resultado->user_id = Auth::id();
        $resultado->cuestionario_id = $request->cuestionario_id;
        $resultado->puntuacion_obtenida = $puntuacion_obtenida;
        $resultado->respuestas = json_encode($request->respuestas);
        $resultado->save();

        return redirect()->route('resultados.show', $resultado)
            ->with('success', 'Resultado registrado correctamente');
    }

    /**
     * Se muestra un resultado
     */
    public function show(Resultado $resultado): Renderable
    {
        if ($resultado->user_id !== Auth::id() && ! Auth::user()->isProfesor()) {
            abort(403);
        }

        return view('resultados.show', compact('resultado'));
    }
}
