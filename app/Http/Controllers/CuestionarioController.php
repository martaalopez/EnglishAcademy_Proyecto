<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Cuestionario;
use Illuminate\Http\Request;

class CuestionarioController extends Controller
{
    public function index()
    {
        // Se cogen todos los cuestionarios de la base de datos
        $cuestionarios = Cuestionario::all();

        return view('cuestionarios.index', compact('cuestionarios'));
    }

    public function create()
    {
        // Se cogen las clases para mostrarlas en el formulario
        $clases = Clase::all();

        return view('cuestionarios.create', compact('clases'));
    }

    public function store(Request $request)
    {
        // Se validan los datos del formulario
        $request->validate([
            'titulo' => 'required|max:50',
            'descripcion' => 'required|max:300',
            'tipo' => 'required|in:gramatica,vocabulario,listening,reading',
        ]);

        $cuestionario = new Cuestionario;

        // Se asignan los datos introducidos por el usuario
        $cuestionario->titulo = $request->input('titulo');
        $cuestionario->descripcion = $request->input('descripcion');
        $cuestionario->tipo = $request->input('tipo');

        // Se asignan  la clase y el profesor autenticado
        $cuestionario->clase_id = auth()->user()->clase_id;
        $cuestionario->profesor_id = auth()->id();

        $cuestionario->save();

        return redirect()->route('cuestionarios.show', $cuestionario)
            ->with('success', 'Cuestionario creado correctamente.');
    }

    public function show(Cuestionario $cuestionario)
    {
        // Se cargan las preguntas con sus opciones
        $cuestionario->load('preguntas.opciones');

        return view('cuestionarios.show', compact('cuestionario'));
    }

    public function showAlumno(Cuestionario $cuestionario)
    {
        // Se cargan los mismos datos pero para la vista del alumno
        $cuestionario->load('preguntas.opciones');

        return view('cuestionarios.alumnoCuestionario', compact('cuestionario'));
    }

    public function edit($id)
    {
        // Se busca el cuestionario por su id
        $cuestionario = Cuestionario::find($id);

        return view('cuestionarios.edit', compact('cuestionario'));
    }

    public function update(Request $request, $id)
    {
        // Se validan nuevamente los datos
        $request->validate([
            'titulo' => 'required|max:50',
            'descripcion' => 'required|max:300',
            'tipo' => 'required|in:gramatica,vocabulario,listening,reading',
        ]);

        $cuestionario = Cuestionario::find($id);

        // Se actualizan los datos del cuestionario
        $cuestionario->titulo = $request->titulo;
        $cuestionario->descripcion = $request->descripcion;
        $cuestionario->tipo = $request->tipo;

        $cuestionario->save();

        return redirect()->route('cuestionarios.show', $cuestionario)
            ->with('success', 'Cuestionario actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Se elimina el cuestionario
        $cuestionario = Cuestionario::find($id);
        $cuestionario->delete();

        return redirect()->route('dashboard.profesor');
    }
}
