@extends('layouts.app')
<!-- Extiende la plantilla base 'app', heredando estructura y estilos de la app -->

@section('contenido')
<!-- Se define la sección 'contenido' que se inyectará en la plantilla -->

<div class="container py-5">
    <main>
        <div class="container py-4">
            <h2>Edita un cuestionario</h2> <!-- Título de la página para editar el cuestionario -->

            <!-- Alert que se muestra si hay errores de validación -->
            @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    <!-- Recorre todos los errores y los muestra en una lista -->
                    @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <!-- Botón para cerrar el alert -->
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulario para actualizar un cuestionario existente -->
            <form action="{{ route('cuestionarios.update',$cuestionario->id) }}" method="post">
                @method("PUT")
                <!-- Indica que la solicitud es de tipo PUT, necesario para actualizar recursos -->
                @csrf
                <!-- Token CSRF para proteger el formulario -->

                <!-- Campo para editar el título del cuestionario -->
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-bold">Titulo del Cuestionario</label>
                    <input type="text" name="titulo" id="titulo" class="form-control"
                        value="{{ $cuestionario->titulo }}" required>
                </div>

                <!-- Campo para editar la descripción del cuestionario -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold">Descripcion del Cuestionario</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control"
                        value="{{ $cuestionario->descripcion }}" required>
                </div>

                <!-- Selector para cambiar el tipo de cuestionario -->
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

                <!-- Botón para enviar el formulario y guardar los cambios -->
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </main>
</div>

@endsection
<!-- Cierre de la sección 'contenido' -->