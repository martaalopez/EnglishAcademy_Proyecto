@extends('layouts.app')

@section('title', 'Detalle del Resultado')

@section('contenido')
<div class="container py-4">

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Resultado del Cuestionario</h3>
        </div>
        <div class="card-body">
            <p><strong>Usuario:</strong> {{ $resultado->user->nombre ?? 'N/A' }}</p>
            <p><strong>Cuestionario:</strong> {{ $resultado->cuestionario->titulo ?? 'N/A' }}</p>
            <p><strong>Puntuación:</strong> {{ $resultado->puntuacion_obtenida }}/5</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Respuestas</h4>
        </div>
        <div class="card-body">
            @php
            $respuestas = json_decode($resultado->respuestas, true);
            @endphp

            @forelse($respuestas as $preguntaId => $opcionId)
            @php
            $opcion = App\Models\Opcion::with('pregunta')->find($opcionId);
            @endphp

            @if($opcion)
            <div class="mb-3 p-3 border rounded">
                <p><strong>Pregunta:</strong> {{ $opcion->pregunta->pregunta }}</p>
                <p><strong>Tu respuesta:</strong> {{ $opcion->opcion }}</p>
                <p>
                    @if($opcion->es_correcta)
                    <span class="text-success fw-bold">Correcta</span>
                    @else
                    <span class="text-danger fw-bold">Incorrecta</span>
                    @endif
                </p>
            </div>
            @endif
            @empty
            <p class="text-muted">No hay respuestas registradas.</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('resultados.index') }}" class="btn btn-secondary">Volver</a>

</div>
@endsection