<?php

use App\Http\Controllers\ClaseController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\OpcionController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Dashboards
    Route::get('/dashboard/alumno', [DashboardController::class, 'alumno'])->name('dashboard.alumno');
    Route::get('/dashboard/profesor', [DashboardController::class, 'profesor'])->name('dashboard.profesor');

    // Clases
    Route::prefix('clases')->name('clases.')->group(function () {
        Route::get('/{clase}', [ClaseController::class, 'show'])->name('show');
        Route::get('/{clase}/participantes', [ClaseController::class, 'participantes'])->name('participantes');
    });

    // Cuestionarios y resultados
    Route::get('/cuestionario/{cuestionario}/alumno', [CuestionarioController::class, 'showAlumno'])->name('cuestionarios.alumno');
    Route::get('/resultado/alumnos', [ResultadoController::class, 'showResultados'])->name('resultados.showResultados');

    // Resources
    Route::resource('cuestionarios', CuestionarioController::class);
    Route::resource('preguntas', PreguntaController::class);
    Route::resource('opciones', OpcionController::class)->parameters(['opciones' => 'opcion']);
    Route::resource('resultados', ResultadoController::class);
    Route::resource('usuarios', UserController::class);

    // Mensajes
    Route::get('/clases/{clase_id}/mensajes/nuevos', [MensajeController::class, 'getNewMessages'])->name('mensajes.nuevos');
    Route::resource('clases.mensajes', MensajeController::class)
        ->only(['index', 'store'])
        ->parameters(['clases' => 'clase_id']);
});
