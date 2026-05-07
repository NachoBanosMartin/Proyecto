@extends('layouts.app')

@section('title', 'Mi perfil - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Mi perfil</h2>
        <p>Consulta y gestiona la información de tu cuenta</p>
    </div>
</section>

<div class="container contenido-pagina">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-4">Datos del usuario</h4>

            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Fecha de registro:</strong> {{ $usuario->fechaRegistro }}</p>
            <p><strong>Cuenta activa:</strong> {{ (int) $usuario->activo === 1 ? 'Sí' : 'No' }}</p>
            <p><strong>Tipo de usuario:</strong> {{ $usuario->tipoUsuario }}</p>
        </div>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-4">Editar perfil</h4>

            <form method="POST" action="{{ route('perfil.actualizar') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre', $usuario->nombre) }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $usuario->email) }}">
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Cambiar contraseña</h5>
                <p class="text-muted">Solo rellena estos campos si quieres cambiar tu contraseña.</p>

                <div class="mb-3">
                    <label for="password_actual" class="form-label">Contraseña actual</label>
                    <input type="password" name="password_actual" id="password_actual" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="password_nueva" class="form-label">Nueva contraseña</label>
                    <input type="password" name="password_nueva" id="password_nueva" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="password_nueva_2" class="form-label">Repetir nueva contraseña</label>
                    <input type="password" name="password_nueva_2" id="password_nueva_2" class="form-control">
                </div>

                <button type="submit" class="btn btn-grey-custom">Guardar cambios</button>
            </form>
        </div>
    </div>

    <div class="card card-custom border-danger mb-4">
        <div class="card-body">
            <h4 class="mb-3 text-danger">Eliminar cuenta</h4>
            <p>Esta acción eliminará tu cuenta y también tus favoritos y comentarios. No se puede deshacer.</p>

            <form method="POST" action="{{ route('perfil.eliminar') }}" onsubmit="return confirm('¿Seguro que quieres eliminar tu cuenta?');">
                @csrf
                @method('DELETE')

                <div class="mb-3">
                    <label for="confirmacion" class="form-label">Escribe ELIMINAR para confirmar</label>
                    <input type="text" name="confirmacion" id="confirmacion" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_eliminar" class="form-label">Tu contraseña</label>
                    <input type="password" name="password_eliminar" id="password_eliminar" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-danger">Eliminar cuenta definitivamente</button>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">Volver al inicio</a>
    </div>
</div>
@endsection