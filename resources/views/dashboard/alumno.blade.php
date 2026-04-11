@extends('layouts.app')
<!-- Extiende la plantilla base 'app' -->

@section('contenido')
<!-- Sección principal de contenido -->

<!-- Se incluye un CSS específico para el dashboard -->
<link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">

<main>
    <div class="container py-4">
        <h2>Mi dashboard</h2> <!-- Título del dashboard -->

        <!-- Alert de errores si los hay -->
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

        <!-- Sección de Gramática -->
        <div class="mb-5">
            <h2 class="h3 mb-3">Gramática</h2>
            <hr class="mb-4">
            @php
            $gramaticaCuestionarios = $cuestionarios->where('tipo', 'gramatica');
            @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($gramaticaCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <!-- Botón para iniciar el cuestionario -->
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.alumno', $cuestionario->id) }}"
                                    class="btn btn-sm btn-info">
                                    Hacer cuestionario
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Mensaje si no hay cuestionarios -->
                <div class="col-12">
                    <div class="alert alert-light text-center py-4">
                        No hay cuestionarios de gramática disponibles
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sección de Vocabulario -->
        <div class="mb-3">
            <h2>Vocabulario</h2>
            <hr class="mb-4">
            @php
            $vocabularioCuestionarios = $cuestionarios->where('tipo', 'vocabulario');
            @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($vocabularioCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.alumno', $cuestionario->id) }}"
                                    class="btn btn-sm btn-info">
                                    Hacer cuestionario
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-4">
                        No hay cuestionarios de vocabulario disponibles
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sección de Reading -->
        <div class="mb-3">
            <h2>Reading</h2>
            <hr class="mb-4">
            @php
            $readingCuestionarios = $cuestionarios->where('tipo', 'reading');
            @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($readingCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.alumno', $cuestionario->id) }}"
                                    class="btn btn-sm btn-info">
                                    Hacer cuestionario
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-4">
                        No hay cuestionarios de reading disponibles
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sección de Listening -->
        <div class="mb-3">
            <h2>Listening</h2>
            <hr class="mb-4">
            @php
            $listeningCuestionarios = $cuestionarios->where('tipo', 'listening');
            @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($listeningCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.alumno', $cuestionario->id) }}"
                                    class="btn btn-sm btn-info">
                                    Hacer cuestionario
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-4">
                        No hay cuestionarios de listening disponibles
                    </div>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</main>

@endsection
<!-- Cierre de la sección 'contenido' -->