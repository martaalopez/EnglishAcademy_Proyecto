@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('contenido')
<div class="container py-5">
    {{-- Cabecera --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Mi Perfil</h1>
            <p class="text-muted">Información personal de la cuenta</p>
        </div>
        <a href="{{ route('dashboard.' . Auth::user()->rol) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    {{-- Tabla de información --}}
    <table class="table table-borderless">
        <tr>
            <td width="120" class="fw-bold text-muted">Nombre:</td>
            <td>{{ Auth::user()->nombre }}</td>
        </tr>
        <tr>
            <td class="fw-bold text-muted">Email:</td>
            <td>{{ Auth::user()->email }}</td>
        </tr>
        <tr>
            <td class="fw-bold text-muted">Rol:</td>
            <td>
                <span class="badge bg-{{ Auth::user()->rol == 'profesor' ? 'warning' : 'info' }}">
                    {{ ucfirst(Auth::user()->rol) }}
                </span>
            </td>
        </tr>
        @if(Auth::user()->nivel)
        <tr>
            <td class="fw-bold text-muted">Nivel:</td>
            <td>{{ Auth::user()->nivel }}</td>
        </tr>
        @endif
        <tr>
            <td class="fw-bold text-muted">Clase:</td>
            <td>{{ Auth::user()->clase_id ?? 'Sin asignar' }}</td>
        </tr>
    </table>

    {{-- Botón para editar perfil --}}
    <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="{{ route('usuarios.edit', Auth::user()->id) }}" class="btn btn-warning"
            style="background-color: #1d4ed8; color: #fff; border: none;">
            <i class="fas fa-edit me-2"></i>Editar Perfil
        </a>

    </div>
</div>
@endsection