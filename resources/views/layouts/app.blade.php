<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'English Academy')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/menu/menu.css') }}">
    @stack('styles')
</head>

<body>

    <div class="dashboard-layout">

        @if(Auth::user()->rol == 'profesor')
        @include('menu.menu_profesor')
        @else
        @include('menu.menu_alumno')
        @endif

        <main class="main-content">
            @yield('contenido')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const btn = document.getElementById('desktopToggleBtn');
        const sidebar = document.getElementById('mainSidebar');

        if (btn && sidebar) {
            btn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }
    </script>

    @stack('scripts')

</body>

</html>