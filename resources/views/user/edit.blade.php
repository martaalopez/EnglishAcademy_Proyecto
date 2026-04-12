@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('contenido')
<div class="container py-5">
    <h2 class="mb-4">Edita mi perfil</h2>

    @if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <form action="{{ route('usuarios.update', Auth::user()->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                value="{{ old('nombre', Auth::user()->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', Auth::user()->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <input type="text" class="form-control" value="{{ Auth::user()->rol }}" disabled>
        </div>

        {{-- Solo los alumnos pueden editar nivel y clase --}}
        @if(Auth::user()->rol === 'alumno')

        <div class="mb-3">
            <label for="nivel" class="form-label fw-bold">Nivel</label>
            <select name="nivel" id="nivel" class="form-select @error('nivel') is-invalid @enderror" required>
                <option value="">Selecciona nivel</option>
                <option value="b1" {{ old('nivel', Auth::user()->nivel) == 'b1' ? 'selected' : '' }}>B1</option>
                <option value="b2" {{ old('nivel', Auth::user()->nivel) == 'b2' ? 'selected' : '' }}>B2</option>
                <option value="c1" {{ old('nivel', Auth::user()->nivel) == 'c1' ? 'selected' : '' }}>C1</option>
            </select>
            @error('nivel')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="clase_id" class="form-label fw-bold">Clase</label>
            <select name="clase_id" id="clase_id" class="form-select @error('clase_id') is-invalid @enderror" required>
                <option value="">Selecciona una clase</option>
                @foreach($clases as $clase)
                <option value="{{ $clase->id }}" {{ old('clase_id', Auth::user()->clase_id) == $clase->id ? 'selected' :
                    '' }}>
                    {{ $clase->nombre }} ({{ strtoupper($clase->nivel) }})
                </option>
                @endforeach
            </select>
            @error('clase_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @endif

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control"
                placeholder="Deja vacío para mantener la contraseña actual">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"
            style="background-color: #1d4ed8; color: #fff; border: none;">Guardar cambios</button>
    </form>
</div>

{{-- Script para sincronizar nivel con la clase seleccionada --}}
@if(Auth::user()->rol === 'alumno')
<script>
    const claseNiveles = {
        @foreach($clases as $clase)
            {{ $clase->id }}: "{{ $clase->nivel }}",
        @endforeach
    };

    const selectClase = document.getElementById('clase_id');
    const selectNivel = document.getElementById('nivel');

    // Mensaje de error 
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger mt-2 d-none';
    errorDiv.textContent = 'El nivel de la clase no coincide con el nivel seleccionado.';
    selectClase.parentElement.appendChild(errorDiv);

    function validarNivelClase() {
        const claseSeleccionada = selectClase.value;
        const nivelSeleccionado = selectNivel.value;

        if (claseSeleccionada && nivelSeleccionado) {
            const nivelDeLaClase = claseNiveles[claseSeleccionada];
            if (nivelDeLaClase !== nivelSeleccionado) {
                // Muestra el error y marca los campos en rojo
                errorDiv.classList.remove('d-none');
                selectClase.classList.add('is-invalid');
                selectNivel.classList.add('is-invalid');
            } else {
                // Todo correcto, limpia los errores
                errorDiv.classList.add('d-none');
                selectClase.classList.remove('is-invalid');
                selectNivel.classList.remove('is-invalid');
                selectNivel.value = nivelDeLaClase;
            }
        }
    }

    selectClase.addEventListener('change', validarNivelClase);
    selectNivel.addEventListener('change', validarNivelClase);
</script>
@endif

@endsection