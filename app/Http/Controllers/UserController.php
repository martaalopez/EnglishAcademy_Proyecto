<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Se muestra un usuario
     */
    public function show(User $usuario): Renderable
    {
        return view('user.show', compact('usuario'));
    }

    /**
     * Se muestra el formulario para editar un usuario
     */
    public function edit(User $usuario): Renderable
    {
        $clases = Clase::all();

        return view('user.edit', compact('usuario', 'clases'));
    }

    /**
     * Se actualiza un usuario
     */
    public function update(Request $request, User $usuario): RedirectResponse
    {
        $esAlumno = $usuario->rol === 'alumno';

        $request->validate([
            'nombre' => 'required|string|max:30',
            'email' => ['required', 'email', Rule::unique('users')->ignore($usuario->id)],
            'password' => 'nullable|min:8',
            // Solo se validan nivel y clase si es alumno
            'nivel' => $esAlumno ? 'required|in:b1,b2,c1' : 'nullable',
            'clase_id' => $esAlumno ? 'required|exists:clases,id' : 'nullable',
        ]);

        // La  clase debe coincidir con el nivel elegido
        if ($esAlumno) {
            $clase = Clase::find($request->clase_id);
            if ($clase && $clase->nivel !== $request->nivel) {
                return back()->withErrors([
                    'clase_id' => 'La clase seleccionada no corresponde al nivel elegido.',
                ])->withInput();
            }
        }

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        if ($esAlumno) {
            $usuario->nivel = $request->nivel;
            $usuario->clase_id = $request->clase_id;
        }

        $usuario->save();

        return redirect()->route('usuarios.show', $usuario->id)
            ->with('success', 'Perfil actualizado correctamente');
    }
}
