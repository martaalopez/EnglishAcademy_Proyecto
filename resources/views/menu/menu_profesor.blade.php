<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Título de la página -->
    <title>Dashboard Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Navbar principal para profesores -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <!-- Botón para menú colapsable en móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarProfesor">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del navbar -->
            <div class="collapse navbar-collapse" id="navbarProfesor">

                <!-- Menú principal -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <!-- Nombre del usuario logueado -->
                    <li class="nav-item">
                        <span class="nav-link text-dark fw-bold">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->nombre }}
                        </span>
                    </li>

                    <!-- Inicio / Home -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard.profesor') }}" class="nav-link ">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>

                    <!-- Resultados de alumnos -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('resultados.showResultados') }}">
                            <i class="fas fa-chart-bar me-1"></i> Resultados de alumnos
                        </a>
                    </li>

                    <!-- Perfil del profesor -->
                    <li class="nav-item">
                        <a href="{{ route('usuarios.show', ['usuario' => Auth::user()->id])  }}" class="nav-link ">
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
                    <button type="submit" class="btn btn-outline-danger btn-sm">
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