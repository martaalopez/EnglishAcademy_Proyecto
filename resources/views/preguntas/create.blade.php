@extends('layouts.app')

@section('contenido')
<div class="container py-5">
    <main>
        <div class="container py-4">

            <!-- Título de la página -->
            <h2>Nueva pregunta</h2>

            <!-- Mostrar errores de validación si existen -->
            @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <!-- Botón para cerrar la alerta -->
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulario para crear una nueva pregunta -->
            <form action="{{ route('preguntas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Token CSRF para seguridad -->

                <!-- Campo oculto para enviar el ID del cuestionario -->
                <input type="hidden" name="cuestionario_id" id="cuestionario_id" class="form-control"
                    value="{{ $cuestionario->id }}">

                <!-- Campo de texto para la pregunta -->
                <div class="mb-3">
                    <label for="pregunta" class="form-label fw-bold">Pregunta</label>
                    <input type="text" name="pregunta" id="pregunta" class="form-control" value="{{ old('pregunta') }}"
                        required>
                </div>

                <!-- Campo de archivo para audio -->
                <div class="mb-3">
                    <label for="audio" class="form-label fw-bold">Audio</label>
                    <input type="file" name="audio" id="audio" class="form-control" accept=".mp3,.wav"
                        value="{{ old('audio') }}">
                </div>

                <!-- Botón de envío -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection