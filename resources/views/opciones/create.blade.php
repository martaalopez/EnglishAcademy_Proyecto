@extends('layouts.app')

@section('contenido')
<div class="container py-5">
    <main>
        <div class="container py-4">

            <!-- Título de la página -->
            <h2>Añade una opción</h2>

            <!-- Mostrar errores de validación -->
            @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <!-- Botón para cerrar alerta -->
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulario para crear una nueva opción -->
            <form action="{{ route('opciones.store') }}" method="POST">
                @csrf
                <!-- Token CSRF por seguridad -->

                <!-- Campo oculto para enviar el ID de la pregunta asociada -->
                <div class="mb-3">
                    <input type="hidden" name="pregunta_id" value="{{ $pregunta->id }}">
                    <div>
                        <!-- Mostrar la pregunta a la que se está añadiendo la opción -->
                        Opción para la pregunta: {{ $pregunta->pregunta }}
                    </div>
                </div>

                <!-- Campo de texto para la opción -->
                <div class="mb-3">
                    <label for="opcion" class="form-label fw-bold">Opción</label>
                    <input type="text" name="opcion" id="opcion" class="form-control" value="{{ old('opcion') }}"
                        required>
                </div>

                <!-- Checkbox para marcar si la opción es correcta -->
                <div class="mb-3">
                    <label for="es_correcta">Esta es la respuesta correcta</label>
                    <input type="checkbox" name="es_correcta" id="es_correcta" value="1" {{ old('es_correcta')
                        ? 'checked' : '' }}>
                </div>

                <!-- Botones para enviar o cancelar -->
                <button type="submit" class="btn btn-success">Guardar</button>
                <!-- Nota: el botón "Cancelar" actualmente también hace submit; lo ideal sería usar un enlace <a> -->
                <a class="btn btn-secondary" href="{{ route('preguntas.index') }}">Cancelar</a>
            </form>

        </div>
    </main>
</div>
@endsection