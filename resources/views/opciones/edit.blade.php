@extends('layouts.app')

@section('contenido')
<div class="container py-5">
    <main>
        <div class="container py-4">
            <h2>Edita la opción</h2>
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

            <!-- Formulario para actualizar la opción existente -->
            <form action="{{ route('opciones.update', $opcion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <input type="hidden" name="pregunta_id" value="{{ $opcion->pregunta_id }}">
                </div>

                <!-- Campo de texto para la opción -->
                <div class="mb-3">
                    <label for="opcion" class="form-label fw-bold">Opción</label>
                    <input type="text" name="opcion" id="opcion" class="form-control" value="{{ $opcion->opcion }}"
                        required>
                </div>

                <!-- Checkbox para marcar si la opción es correcta -->
                <div class="mb-3">
                    <label for="es_correcta">Esta es la respuesta correcta</label>
                    <input type="checkbox" name="es_correcta" id="es_correcta" value="1" {{ $opcion->es_correcta ?
                    'checked' : '' }}>
                </div>

                <!-- Botón para enviar los cambios -->
                <button type="submit" class="btn btn-success"
                    style="background-color: #1d4ed8; color: #fff; border: none;">Guardar cambios</button>

            </form>
        </div>
    </main>
</div>
@endsection