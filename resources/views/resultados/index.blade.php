@extends('layouts.app')

@section('title', 'Mis Resultados')

@section('contenido')
<div class="container py-4">

    <h2 class="mb-4">Mis Resultados</h2>

    <!-- Mensaje de éxito -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <!-- Validación de resultados vacíos -->
    @if($resultados->isEmpty())
    <div class="alert alert-info">
        No tienes resultados registrados todavía.
    </div>
    @else
    <!-- Tabla de resultados -->
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