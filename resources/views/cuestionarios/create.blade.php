@extends('layouts.app')
<!-- Se extiende la plantilla base 'app' para heredar la estructura general de la aplicación -->

@section('contenido')
<!-- Se define la sección 'contenido' que será inyectada en la plantilla -->

<div class="container py-5">
    <main>
        <div class="container py-4">
            <h2>Crea un cuestionario</h2> <!-- Título principal de la página -->

            <!-- Se muestra un alert si hay errores de validación -->
            @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    <!-- Se recorren todos los errores y se muestran en una lista -->
                    @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <!-- Botón para cerrar el alert -->
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulario para crear un nuevo cuestionario -->
            <form action="{{ route('cuestionarios.store') }}" method="POST">
                @csrf
                <!-- Token CSRF para proteger contra ataques de tipo cross-site request forgery -->

                <!-- Campo para el título del cuestionario -->
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-bold">Titulo del Cuestionario</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}"
                        required>
                </div>

                <!-- Campo para la descripción del cuestionario -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold">Descripcion del Cuestionario</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control"
                        value="{{ old('descripcion') }}" required>
                </div>

                <!-- Selector para el tipo de cuestionario -->
                <div class="mb-3">
                    <label for="tipo" class="form-label fw-bold">Tipo de Cuestionario</label>
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="">Selecciona un tipo</option>
                        <option value="gramatica" {{ old('tipo')=='gramatica' ? 'selected' : '' }}>Gramática</option>
                        <option value="vocabulario" {{ old('tipo')=='vocabulario' ? 'selected' : '' }}>Vocabulario
                        </option>
                        <option value="listening" {{ old('tipo')=='listening' ? 'selected' : '' }}>Listening</option>
                        <option value="reading" {{ old('tipo')=='reading' ? 'selected' : '' }}>Reading</option>
                    </select>
                </div>

                <!-- Campo que muestra la clase del usuario (solo lectura) -->
                <div class="mb-3">
                    <label class="form-label">Clase</label>
                    <input type="text" name="clase_id" id="clase_id" class="form-control"
                        value="{{ Auth::user()->clase_id }}" disabled>
                </div>

                <!-- Botón para enviar el formulario -->
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </main>
</div>

@endsection
<!-- Cierre de la sección 'contenido' -->