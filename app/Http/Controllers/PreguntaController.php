<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Pregunta;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    /**
     * Se obtienen todas las preguntas de un cuestionario
     */
    public function index(Request $request)
    {
        $cuestionario_id = $request->query('cuestionario_id');
        $cuestionario = Cuestionario::findOrFail($cuestionario_id);
        $cuestionarios = Cuestionario::all();
        $preguntas = Pregunta::where('cuestionario_id', $cuestionario_id)
            ->with('cuestionario')
            ->get();

        return view('cuestionarios.show', [
            'preguntas' => $preguntas,
            'cuestionario' => $cuestionario,
            'cuestionarios' => $cuestionarios,
        ]);
    }

    /**
     * Se muestra el formulario para crear una nueva pregunta
     */
    public function create(Request $request)
    {
        $cuestionario_id = $request->query('cuestionario_id');
        $cuestionario = Cuestionario::findOrFail($cuestionario_id);

        return view('preguntas.create', compact('cuestionario'));
    }

    /**
     * Se guarda una nueva pregunta en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'pregunta' => 'required|string|max:100',
            'audio' => 'nullable|file|mimes:mp3,wav',
            'cuestionario_id' => 'required|exists:cuestionarios,id',
        ]);

        if (Pregunta::where('cuestionario_id', $request->cuestionario_id)->count() >= 5) {
            return back()->withErrors(['pregunta' => 'No puedes agregar más de 5 preguntas'])->withInput();
        }

        $pregunta = new Pregunta;
        $pregunta->pregunta = $request->input('pregunta');
        $pregunta->audio = $request->file('audio')?->store('audios', 'public');
        $pregunta->cuestionario_id = $request->input('cuestionario_id');
        $pregunta->save();

        return redirect()->route('cuestionarios.show', ['cuestionario' => $request->cuestionario_id])
            ->with('success', 'Pregunta creada correctamente');
    }

    /**
     * Se muestra una pregunta con sus opciones
     */
    public function show(Pregunta $pregunta): Renderable
    {
        $pregunta->load('opciones', 'cuestionario');

        return view('cuestionarios.show', compact('pregunta'));
    }

    /**
     * Se muestra el formulario para editar una pregunta
     */
    public function edit($id): Renderable
    {
        $pregunta = Pregunta::find($id);
        $cuestionarios = Cuestionario::all();

        return view('preguntas.edit', compact('pregunta', 'cuestionarios'));
    }
    /**
     * Se actualiza una pregunta
     */
    public function update(Request $request, Pregunta $pregunta)
    {
        $request->validate([
            'pregunta' => 'required|string|max:100',
            'audio' => 'nullable|file|mimes:mp3,wav',
            'cuestionario_id' => 'required|exists:cuestionarios,id',
        ]);

        $pregunta->pregunta = $request->input('pregunta');
        $pregunta->audio = $request->file('audio')?->store('audios', 'public');
        $pregunta->cuestionario_id = $request->input('cuestionario_id');
        $pregunta->save();

        return redirect()->route('cuestionarios.show', ['cuestionario' => $pregunta->cuestionario_id])
            ->with('success', 'Pregunta actualizada correctamente');
    }
    /**
     * Se elimina una pregunta
     */
    public function destroy(Pregunta $pregunta)
    {
        $cuestionario_id = $pregunta->cuestionario_id;
        $pregunta->delete();

        return redirect()->route('cuestionarios.show', ['cuestionario' => $cuestionario_id])
            ->with('success', 'Pregunta eliminada correctamente');
    }
}
