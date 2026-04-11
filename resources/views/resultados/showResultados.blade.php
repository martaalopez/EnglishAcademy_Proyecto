@extends('layouts.app')

@section('title', 'Resultados de los alumnos')

@section('contenido')
<div class="container py-4">
    <h2 class="mb-4">Resultados de los alumnos</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($resultados->isEmpty())
    <div class="alert alert-info">
        No hay resultados registrados todavía.
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Cuestionario</th>
                    <th>Puntuación</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultados as $resultado)
                <tr>
                    <td>{{ $resultado->cuestionario->titulo ?? 'N/A' }}</td>
                    <td>{{ $resultado->puntuacion_obtenida }}/5</td>
                    <td>{{ $resultado->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('resultados.show', $resultado->id) }}" class="btn btn-sm btn-info">
                            Ver detalles
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection