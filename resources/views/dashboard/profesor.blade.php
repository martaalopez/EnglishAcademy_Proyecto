@extends('layouts.app')
@section('contenido')


<main>
    <div class="container py-4">

        <!-- Cabecera del dashboard con botón para crear un nuevo cuestionario -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard de administración</h2>
            <a href="{{ route('cuestionarios.create') }}" class="btn btn-primary">
                + Nuevo Cuestionario
            </a>
        </div>

        <!-- Alert de errores si existen -->
        @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- SECCIÓN: Gramática --}}
        <div class="mb-5">
            <h2 class="h3 mb-3">Gramática</h2>
            <hr class="mb-4">

            @php $gramaticaCuestionarios = $cuestionarios->where('tipo', 'gramatica'); @endphp
            <!-- Filtra por tipo -->

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($gramaticaCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <!-- Título y descripción del cuestionario -->
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <!-- Botones compactos para ver, editar o eliminar -->
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.show', $cuestionario) }}"
                                    class="btn btn-sm btn-info px-2 py-1" title="Ver detalles">
                                    Ver
                                </a>
                                <a href="{{ route('cuestionarios.edit', $cuestionario) }}"
                                    class="btn btn-sm btn-warning px-2 py-1" title="Editar">
                                    Editar
                                </a>
                                <form action="{{ route('cuestionarios.destroy', $cuestionario->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1"
                                        onclick="return confirm('¿Eliminar este cuestionario?')" title="Eliminar">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Mensaje si no hay cuestionarios disponibles -->
                <div class="col-12">
                    <div class="alert alert-light text-center py-4">
                        No hay cuestionarios de gramática disponibles
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- SECCIÓN: Vocabulario --}}
        <div class="mb-5">
            <h2 class="h3 mb-3">Vocabulario</h2>
            <hr class="mb-4">

            @php $vocabularioCuestionarios = $cuestionarios->where('tipo', 'vocabulario'); @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($vocabularioCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <!-- Botones ver/editar/eliminar -->
                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.show', $cuestionario) }}"
                                    class="btn btn-sm btn-info px-2 py-1" title="Ver detalles">Ver</a>
                                <a href="{{ route('cuestionarios.edit', $cuestionario) }}"
                                    class="btn btn-sm btn-warning px-2 py-1" title="Editar">Editar</a>
                                <form action="{{ route('cuestionarios.destroy', $cuestionario->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1"
                                        onclick="return confirm('¿Eliminar este cuestionario?')"
                                        title="Eliminar">Eliminar</button>
                                </form>
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

        {{-- SECCIÓN: Reading --}}
        <div class="mb-5">
            <h2 class="h3 mb-3">Reading</h2>
            <hr class="mb-4">

            @php $readingCuestionarios = $cuestionarios->where('tipo', 'reading'); @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($readingCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.show', $cuestionario) }}"
                                    class="btn btn-sm btn-info px-2 py-1" title="Ver detalles">Ver</a>
                                <a href="{{ route('cuestionarios.edit', $cuestionario) }}"
                                    class="btn btn-sm btn-warning px-2 py-1" title="Editar">Editar</a>
                                <form action="{{ route('cuestionarios.destroy', $cuestionario->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1"
                                        onclick="return confirm('¿Eliminar este cuestionario?')"
                                        title="Eliminar">Eliminar</button>
                                </form>
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

        {{-- SECCIÓN: Listening --}}
        <div class="mb-5">
            <h2 class="h3 mb-3">Listening</h2>
            <hr class="mb-4">

            @php $listeningCuestionarios = $cuestionarios->where('tipo', 'listening'); @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($listeningCuestionarios as $cuestionario)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $cuestionario->titulo }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $cuestionario->descripcion ?: 'Sin
                                descripción' }}</p>

                            <div class="d-flex justify-content-start gap-2">
                                <a href="{{ route('cuestionarios.show', $cuestionario) }}"
                                    class="btn btn-sm btn-info px-2 py-1" title="Ver detalles">Ver</a>
                                <a href="{{ route('cuestionarios.edit', $cuestionario) }}"
                                    class="btn btn-sm btn-warning px-2 py-1" title="Editar">Editar</a>
                                <form action="{{ route('cuestionarios.destroy', $cuestionario->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1"
                                        onclick="return confirm('¿Eliminar este cuestionario?')"
                                        title="Eliminar">Eliminar</button>
                                </form>
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