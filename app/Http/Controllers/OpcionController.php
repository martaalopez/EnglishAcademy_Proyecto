<?php

namespace App\Http\Controllers;

use App\Models\Opcion;
use App\Models\Pregunta;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OpcionController extends Controller
{
    public function index(Request $request) {}

    public function create(Request $request)
    {
        // Se cogen todas las preguntas
        $preguntas = Pregunta::all();

        // Se recoge el id de la pregunta desde la URL
        $pregunta_id = $request->query('pregunta_id');

        $pregunta = null;

        // Si hay id, se busca la pregunta
        if ($pregunta_id) {
            $pregunta = Pregunta::find($pregunta_id);
        }

        return view('opciones.create', compact('preguntas', 'pregunta', 'pregunta_id'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Se validan los datos
        $request->validate([
            'opcion' => 'required|string|max:50',
            'es_correcta' => 'nullable|boolean',
            'pregunta_id' => 'required|exists:preguntas,id',
        ]);

        // Se comprueba que no haya más de 3 opciones por pregunta
        if (Opcion::where('pregunta_id', $request->pregunta_id)->count() >= 3) {
            return back()->withErrors([
                'opcion' => 'No puedes agregar más de 3 opciones',
            ])->withInput();
        }

        // Se comprueba que solo haya una opción correcta
        if ($request->has('es_correcta') &&
            Opcion::where('pregunta_id', $request->pregunta_id)
                ->where('es_correcta', 1)
                ->exists()) {

            return back()->withErrors([
                'es_correcta' => 'Ya existe una opción correcta para esta pregunta',
            ])->withInput();
        }

        // Se crea la opción
        $opcion = new Opcion;
        $opcion->opcion = $request->input('opcion');
        $opcion->es_correcta = $request->has('es_correcta') ? 1 : 0;
        $opcion->pregunta_id = $request->input('pregunta_id');
        $opcion->save();

        // Se obtiene el cuestionario al que pertenece la pregunta
        $cuestionario_id = $opcion->pregunta->cuestionario_id;

        return redirect()->route('cuestionarios.show', ['cuestionario' => $cuestionario_id])
            ->with('success', 'Opción creada correctamente');
    }

    public function edit(Opcion $opcion): Renderable
    {
        // Se obtiene la pregunta relacionada con la opción
        $pregunta = $opcion->pregunta;

        return view('opciones.edit', compact('opcion', 'pregunta'));
    }

    public function update(Request $request, Opcion $opcion): RedirectResponse
    {
        // Se validan los datos
        $request->validate([
            'opcion' => 'required|string|max:200',
            'es_correcta' => 'nullable|boolean',
            'pregunta_id' => 'required|exists:preguntas,id',
        ]);

        // Se actualizan los datos de la opción
        $opcion->opcion = $request->input('opcion');
        $opcion->es_correcta = $request->has('es_correcta') ? 1 : 0;
        $opcion->pregunta_id = $request->input('pregunta_id');
        $opcion->save();

        // Se obtiene el cuestionario
        $cuestionario_id = $opcion->pregunta->cuestionario_id;

        return redirect()->route('cuestionarios.show', ['cuestionario' => $cuestionario_id])
            ->with('success', 'Opción actualizada correctamente');
    }

    public function destroy(Opcion $opcion): RedirectResponse
    {
        // Se obtiene el cuestionario antes de eliminar
        $cuestionario_id = $opcion->pregunta->cuestionario_id;

        // Se elimina la opción
        $opcion->delete();

        return redirect()->route('cuestionarios.show', ['cuestionario' => $cuestionario_id])
            ->with('success', 'Opción eliminada correctamente');
    }
}
