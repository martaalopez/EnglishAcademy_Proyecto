<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/auth/login.css'])
</head>

<body>
    <div class="container">

        <!-- Se muestra el texto de bienvenida -->
        <div class="bienvenida-text">
            <h1>
                Bienvenido a English Academy <br>
                <span class="h2">Accede a tu cuenta</span>
            </h1>
            <p>
                Aprende inglés con los mejores cursos y profesores.
            </p>
        </div>

        <!-- Se muestra la tarjeta del formulario de login -->
        <div class="card">
            <h3 class="text-center">Iniciar sesión</h3>

            <!-- Se define el formulario -->
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <!-- Se incluye el token CSRF para la seguridad -->

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <!-- Se muestra el campo email -->
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <!-- Se muestra el campo password  -->
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Se muestra el botón para enviar el formulario -->
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Acceder
                </button>

                <p class="text-center mb-0">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}">Regístrate</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>