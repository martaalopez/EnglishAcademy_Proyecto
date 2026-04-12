@extends('layouts.app')

@section('contenido')
<div class="container py-5">
    <main>
        <div class="container py-4">
            <h2>Editar pregunta</h2>
            @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <!-- Botón para cerrar la alerta -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulario para actualizar la pregunta -->
            <form action="{{ route('preguntas.update', $pregunta) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Campo oculto para mantener la relación con el cuestionario -->
                <input type="hidden" name="cuestionario_id" value="{{ $pregunta->cuestionario_id }}">

                <!-- Campo de texto para la pregunta -->
                <div class="mb-3">
                    <label for="pregunta" class="form-label fw-bold">Pregunta</label>
                    <input type="text" name="pregunta" id="pregunta" class="form-control"
                        value="{{ old('pregunta', $pregunta->pregunta) }}" required>
                </div>

                <!-- Campo de archivo para actualizar audio -->
                <div class="mb-3">
                    <label for="audio" class="form-label fw-bold">Audio</label>
                    <input type="file" name="audio" id="audio" class="form-control" accept=".mp3,.wav">
                    @if($pregunta->audio)
                    <small class="text-muted">Archivo actual: {{ $pregunta->audio }}</small>
                    @endif
                </div>

                <!-- Botón de envío -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Guardar
                </button>

            </form>
        </div>
    </main>
</div>
@endsection