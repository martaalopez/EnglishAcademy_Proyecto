@extends('layouts.app')

@section('title', $cuestionario->titulo)

@section('contenido')


@php
// Contar cuántas preguntas están hechas
$preguntasCompletas = $cuestionario->preguntas->filter(function($pregunta) {
return $pregunta->opciones->count() >= 2
&& $pregunta->opciones->where('es_correcta', true)->count() > 0;
})->count();

// Determina si el cuestionario puede finalizar
$puedeTerminar = $preguntasCompletas >= 5;
@endphp

<div class="container py-4">

    <!-- Cabecera del cuestionario -->
    <div class="card mb-3">
        <div class="card-body">
            <h2>{{ $cuestionario->titulo }}</h2>
            <p class="text-muted">{{ $cuestionario->descripcion }}</p>

            <!-- Botón para agregar una nueva pregunta-->
            @if(!$puedeTerminar)
            <a href="{{ route('preguntas.create', ['cuestionario_id' => $cuestionario->id]) }}" class="btn btn-success"
                style="background-color: #1d4ed8; color: #fff; border: none;">
                Agregar Pregunta
            </a>
            @else
            <button class="btn btn-secondary" disabled>Límite de 5 preguntas alcanzado</button>
            @endif
        </div>
    </div>

    <!-- Listado de preguntas -->
    @forelse($cuestionario->preguntas as $pregunta)
    <div class="card mb-3">
        <div class="card-body">

            <!-- Cabecera de la pregunta con acciones -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">{{ $pregunta->pregunta }}</h5>
                <div>
                    <!-- Botón editar pregunta -->
                    <a href="{{ route('preguntas.edit', $pregunta) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <!-- Formulario para eliminar pregunta -->
                    <form action="{{ route('preguntas.destroy', $pregunta) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar esta pregunta?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reproducción de audio si existe -->
            @if($pregunta->audio)
            <audio controls class="mb-2" style="height:40px;">
                <source src="{{ asset('storage/'.$pregunta->audio) }}" type="audio/mpeg">
            </audio>
            @endif

            <!-- Listado de opciones de la pregunta -->
            <h6 class="text-muted">Opciones:</h6>
            @forelse($pregunta->opciones as $opcion)
            <div
                class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 {{ $opcion->es_correcta ? 'border-success bg-success bg-opacity-10' : '' }}">
                <span>
                    {{ $opcion->opcion }}
                    @if($opcion->es_correcta)
                    <span class="badge bg-success ms-1">Correcta</span>
                    @endif
                </span>
                <div>
                    <!-- Botón editar opción -->
                    <a href="{{ route('opciones.edit', $opcion) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <!-- Formulario eliminar opción -->
                    <form action="{{ route('opciones.destroy', $opcion) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar esta opción?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-muted">No hay opciones para esta pregunta</p>
            @endforelse

            <!-- Botón para añadir opción si hay menos de 3 -->
            @if($pregunta->opciones->count() < 3) <a
                href="{{ route('opciones.create', ['pregunta_id' => $pregunta->id]) }}"
                class="btn btn-primary btn-sm mt-1">
                <i class="fas fa-plus me-1"></i>Añadir Opción
                </a>
                @endif

                <!-- Alertas de validación interna de la pregunta -->
                @if($pregunta->opciones->count() > 0 && !$pregunta->opciones->where('es_correcta', true)->count())
                <div class="alert alert-warning mt-2 py-1 small">Sin opción correcta marcada</div>
                @endif
                @if($pregunta->opciones->count() > 0 && $pregunta->opciones->count() < 2) <div
                    class="alert alert-info mt-2 py-1 small">Necesitas al menos 2 opciones
        </div>
        @endif

    </div>
</div>
@empty
<!-- Mensaje si no hay preguntas en el cuestionario -->
<div class="alert alert-secondary text-center">No hay preguntas en este cuestionario</div>
@endforelse

<!-- Botón para finalizar cuestionario -->
<div class="mt-3">
    @if($puedeTerminar)
    <a href="{{ route('dashboard.profesor') }}" class="btn btn-success btn-lg w-100"
        style="background-color: #1d4ed8; color: #fff; border: none;">
        Finalizar cuestionario
    </a>
    @else
    <button class="btn btn-secondary btn-lg w-100" disabled>
        Finalizar cuestionario ({{ $preguntasCompletas }}/5 preguntas completas)
    </button>
    @endif
</div>

</div>

@endsection