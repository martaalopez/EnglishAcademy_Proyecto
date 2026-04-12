@extends('layouts.app')

@section('contenido')

<div class="container py-5">
    <main>
        <div class="container py-4">
            <h2>Edita un cuestionario</h2>

            @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>

                    @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulario para actualizar un cuestionario -->
            <form action="{{ route('cuestionarios.update',$cuestionario->id) }}" method="post">
                @method("PUT")
                @csrf

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
                <button type="submit" class="btn btn-success"
                    style="background-color: #1d4ed8; color: #fff; border: none;">Guardar</button>
            </form>
        </div>
    </main>
</div>

@endsection