<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Título de la página -->
    <title>Dashboard Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/menu/menu.css') }}">
</head>

<body>

    <!-- Navbar principal para alumnos -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <!-- Botón para menú colapsable en móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAlumno">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del navbar -->
            <div class="collapse navbar-collapse" id="navbarAlumno">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <!-- Inicio / Home -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.alumno') }}">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>

                    <!-- Resultados del alumno -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('resultados.index') }}">
                            <i class="fas fa-chart-bar me-1"></i> Mis Resultados
                        </a>
                    </li>

                    <!-- Perfil del alumno -->
                    <li class="nav-item">
                        <a href="{{ route('usuarios.show', ['usuario' => Auth::user()->id])  }}" class="nav-link">
                            <i class="fas fa-home me-1"></i> Mi perfil
                        </a>
                    </li>

                    <!-- Chat de la clase -->
                    <li class="nav-item">
                        <a href="{{ route('clases.mensajes.index', Auth::user()->clase_id) }}" class="nav-link">
                            <i class="fas fa-comments me-1"></i> Chat de la clase
                        </a>
                    </li>

                </ul>

                <!-- Botón de logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión
                    </button>
                </form>


            </div>
        </div>
    </nav>
    <main class="py-4">
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>