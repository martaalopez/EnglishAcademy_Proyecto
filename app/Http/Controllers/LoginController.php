<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Se muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Se muestra el formulario de registro
    public function showRegisterForm()
    {
        // Se obtienen las clases para el formulario
        $clases = Clase::all();

        return view('auth.register', compact('clases'));
    }

    // Procesa el registro de un usuario
    public function register(Request $request)
    {
        // Se validan los datos 
        $request->validate([
            'nombre' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:alumno,profesor',
            'nivel' => 'nullable|in:b1,b2,c1',
            'clase_id' => 'nullable|exists:clases,id',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El formato del email es incorrecto.',
            'email.unique' => 'Este email ya está registrado en el sistema.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres.',
            'rol.required' => 'Debes seleccionar si eres profesor o alumno.',
        ]);

        // Si es profesor, se comprueba que no haya uno en esa clase
        if ($request->rol === 'profesor') {
            $profesorExistente = User::where('clase_id', $request->clase_id)
                ->where('rol', 'profesor')
                ->exists();

            if ($profesorExistente) {
                return back()->withErrors([
                    'clase_id' => 'Ya existe un profesor asignado a esta clase.',
                ])->withInput();
            }
        }

        // Se comprueba que el nivel coincida con el de la clase
        if ($request->clase_id) {
            $clase = Clase::find($request->clase_id);
            if ($clase && $request->nivel && $clase->nivel !== $request->nivel) {
                return back()->withErrors([
                    'nivel' => 'El nivel seleccionado no coincide con el nivel de la clase.',
                ])->withInput();
            }
        }
        // Si es alumno, comprobar que la clase tiene profesor
        if ($request->rol === 'alumno' && $request->clase_id) {
            $clase = Clase::find($request->clase_id);

            if (! $clase || ! $clase->profesor_id) {
                return back()->withErrors([
                    'clase_id' => 'No puedes unirte a esta clase porque no tiene profesor .',
                ])->withInput();
            }
        }

        // Se crea el nuevo usuario
        $user = new User;
        $user->nombre = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->rol = $request->input('rol');
        $user->nivel = $request->input('nivel');
        $user->clase_id = $request->input('clase_id');
        $user->save();

        // Si es profesor, se guarda su id en la clase
        if ($request->rol === 'profesor' && $request->clase_id) {
            $clase = Clase::find($request->clase_id);
            $clase->profesor_id = $user->id;
            $clase->save();
        }

        // Se inicia sesión 
        Auth::login($user);

        return $this->redirectPorRol($user);
    }

    // Procesa el login
    public function login(Request $request)
    {
        // Validación de credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El formato del email es incorrecto.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Se regenera la sesión por seguridad
            $request->session()->regenerate();

            return $this->redirectPorRol(Auth::user());
        }

        // Si falla el login
        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    // Cierra la sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout();

        // Se limpia la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Redirige según el rol del usuario
    private function redirectPorRol(User $user)
    {
        if ($user->isProfesor()) {
            return redirect()->route('dashboard.profesor');
        } else {
            return redirect()->route('dashboard.alumno');
        }
    }
}
