@extends('layouts.app')

@section('title', $cuestionario->titulo)

@section('contenido')

<div class="container py-5" style="max-width:900px;">

    <!-- Se muestra la cabecera del cuestionario -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">

            <h2 class="fw-bold mb-2">
                {{ $cuestionario->titulo }}
            </h2>

            <p class="text-muted mb-3">
                {{ $cuestionario->descripcion }}
            </p>

            <!-- Se muestra el botón para volver al dashboard -->
            <a href="{{ route('dashboard.alumno') }}" class="btn btn-outline-secondary btn-sm">
                ← Volver al dashboard
            </a>

        </div>
    </div>

    <!-- Se define el formulario que enviará las respuestas al route resultados.store -->
    <form method="POST" action="{{ route('resultados.store') }}">
        @csrf
        <!-- Se envía el ID del cuestionario -->
        <input type="hidden" name="cuestionario_id" value="{{ $cuestionario->id }}">

        <!-- Se recorren todas las preguntas del cuestionario -->
        @foreach($cuestionario->preguntas as $pregunta)

        <div class="card shadow-sm mb-4 border-0">

            <div class="card-body">
                <!-- Se muestra el texto de la pregunta -->
                <h5 class="fw-semibold mb-3">
                    {{ $pregunta->pregunta }}
                </h5>

                <!-- Se recorren todas las opciones de la pregunta -->
                @foreach($pregunta->opciones as $opcion)

                <!-- Se muestra cada opción como un radio button -->
                <label class="d-block border rounded p-3 mb-2 opcion-hover">

                    <input type="radio" name="respuestas[{{ $pregunta->id }}]" value="{{ $opcion->id }}"
                        class="form-check-input me-2" required>

                    {{ $opcion->opcion }}

                </label>

                @endforeach

            </div>

        </div>

        @endforeach

        <!-- Se muestra el botón para enviar el cuestionario -->
        <div class="text-center mt-4">

            <button class="btn btn-success btn-lg px-5">
                Enviar cuestionario
            </button>

        </div>

    </form>

</div>

@endsection