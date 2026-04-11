@extends('layouts.app')
<!-- Extiende la plantilla base 'app', heredando estilos y estructura general -->

@section('contenido')
<!-- Sección principal de contenido -->

<div class="container py-4">

    <!-- Mensaje de éxito tras enviar un mensaje -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Área donde se muestran los mensajes con scroll vertical -->
    <div style="height: 55vh; overflow-y: auto;" id="messages-area" class="mb-3">

        <!-- Si hay mensajes, los recorremos -->
        @if($mensajes->count() > 0)
        @foreach($mensajes as $mensaje)
        <div
            class="mb-3 d-flex {{ $mensaje->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
            <!-- Si el mensaje es del usuario autenticado, se alinea a la derecha; si no, a la izquierda -->

            <div style="max-width: 65%;">
                <!-- Cabecera del mensaje: nombre del usuario y hora -->
                <div class="mb-1">
                    <strong>{{ $mensaje->user->nombre }}</strong>
                    <small class="text-muted">{{ $mensaje->created_at->format('H:i') }}</small>
                </div>

                <!-- Contenido del mensaje -->
                <div
                    class="p-2 rounded {{ $mensaje->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-light border' }}">
                    {{ $mensaje->mensaje }}
                </div>
            </div>
        </div>
        @endforeach
        @else
        <!-- Mensaje si no hay mensajes -->
        <p class="text-muted text-center mt-5">No hay mensajes todavía</p>
        @endif
    </div>

    <hr>

    <!-- Formulario para enviar un nuevo mensaje -->
    <form action="{{ route('clases.mensajes.store', $clase->id) }}" method="POST">
        @csrf
        <input type="hidden" name="clase_id" value="{{ $clase->id }}">

        <div class="mb-3">
            <label for="mensaje">Mensaje</label>
            <input type="text" name="mensaje" id="mensaje" class="form-control @error('mensaje') is-invalid @enderror"
                placeholder="Escribe tu mensaje..." autocomplete="off" required>
            @error('mensaje')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botones de enviar y volver al dashboard -->
        <button type="submit" class="btn btn-success">Enviar</button>
        <a href="{{ route('dashboard.' . Auth::user()->rol) }}" class="btn btn-success">Volver</a>
    </form>

</div>

<!-- Script para hacer scroll automático al final del área de mensajes -->
<script>
    const area = document.getElementById('messages-area');
    if (area) area.scrollTop = area.scrollHeight;
</script>

@endsection
<!-- Cierre de la sección 'contenido' -->