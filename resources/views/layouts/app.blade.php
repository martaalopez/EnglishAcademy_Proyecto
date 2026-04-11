<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración de codificación y responsive -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'English Academy')</title>

    <!-- Bootstrap CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos  de distintas secciones -->
    <link rel="stylesheet" href="{{ asset('css/opciones/opciones_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/preguntas/preguntas_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/resultados/resultados_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/user_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">

    <!-- Permite agregar estilos adicionales desde vistas hijas -->
    @stack('styles')
</head>

<body>
    <!-- Menú según rol del usuario -->
    @if(Auth::user()->rol == 'profesor')
    @include('menu.menu_profesor')
    @else
    @include('menu.menu_alumno')
    <!-- Menú para alumnos -->
    @endif
    <!-- Contenido principal de cada vista -->
    @yield('contenido')

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>