<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    public function index($clase_id)
    {
        // Se busca la clase o da error si no existe
        $clase = Clase::findOrFail($clase_id);

        // Se comprueba que el usuario tenga acceso a la clase
        if (Auth::user()->clase_id != $clase_id && Auth::user()->rol !== 'profesor') {
            abort(403, 'No tienes acceso a esta clase');
        }

        // Se obtienen los mensajes de la clase con el usuario que los ha enviado
        $mensajes = Mensaje::with('user')
            ->where('clase_id', $clase_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mensajes.create', compact('clase', 'mensajes'));
    }

    public function store(Request $request)
    {
        // Se validan los datos del mensaje
        $request->validate([
            'mensaje' => 'required|string|max:1000',
            'clase_id' => 'required|exists:clases,id',
        ]);

        // Se crea el mensaje en la base de datos
        $mensaje = Mensaje::create([
            'user_id' => Auth::id(), // Usuario que envía el mensaje
            'mensaje' => $request->mensaje,
            'clase_id' => $request->clase_id,
        ]);

        // Se redirige de nuevo a la lista de mensajes
        return redirect()->route('clases.mensajes.index', ['clase_id' => $request->clase_id])
            ->with('success', 'Mensaje enviado correctamente');
    }
}
