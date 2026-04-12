<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>

<body>
    <div class="container">

        <!-- Se muestra el texto de bienvenida  -->
        <div class="registro-text">
            <h1>
                Crea tu cuenta <br>
                <span class="h2">Es rápido y fácil</span>
            </h1>
            <p>
                Regístrate para empezar a usar English Academy
            </p>
        </div>

        <!-- Se muestra el formulario de registro -->
        <div class="card">
            <h3 class="text-center mb-4">Registro</h3>

            <!-- Se define el formulario que enviará los datos al route register.post -->
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <!-- Se incluye el token CSRF para seguridad -->

                <!-- Se muestran los campos de nombre y email en dos columnas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                            value="{{ old('nombre') }}" required>
                        @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Se muestran los campos de rol y nivel -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">¿Eres profesor o alumno?</label>
                        <select name="rol" class="form-select @error('rol') is-invalid @enderror" required>
                            <option value="">Selecciona</option>
                            <option value="profesor" {{ old('rol')=='profesor' ? 'selected' : '' }}>Profesor</option>
                            <option value="alumno" {{ old('rol')=='alumno' ? 'selected' : '' }}>Alumno</option>
                        </select>
                        @error('rol')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Elige tu nivel</label>
                        <select name="nivel" class="form-select @error('nivel') is-invalid @enderror">
                            <option value="">Selecciona nivel</option>
                            <option value="b1" {{ old('nivel')=='b1' ? 'selected' : '' }}>B1</option>
                            <option value="b2" {{ old('nivel')=='b2' ? 'selected' : '' }}>B2</option>
                            <option value="c1" {{ old('nivel')=='c1' ? 'selected' : '' }}>C1</option>
                        </select>
                        @error('nivel')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Se muestra el selector de clase según el nivel -->
                <div class="mb-3">
                    <label class="form-label">Elige la clase correspondiente según tu nivel</label>
                    <select name="clase_id" class="form-select @error('clase_id') is-invalid @enderror" required>
                        <option value="">Selecciona una clase</option>
                        <!-- Se recorren las clases enviadas desde el controlador -->
                        @foreach($clases as $clase)
                        <option value="{{ $clase->id }}" {{ old('clase_id')==$clase->id ? 'selected' : '' }}>
                            {{ $clase->nombre }} ({{ strtoupper($clase->nivel) }})
                        </option>
                        @endforeach
                    </select>
                    @error('clase_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Se muestra el campo de contraseña -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Se muestra el botón para enviar el formulario -->
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Registrarse
                </button>

                <!-- Se muestra el enlace para ir al login -->
                <p class="text-center mb-0">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}">Inicia sesión</a>
                </p>

            </form>
        </div>
    </div>

    <!-- Se incluye Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>