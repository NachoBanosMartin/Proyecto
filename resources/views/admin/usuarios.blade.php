@extends('layouts.app')

@section('title', 'Administrar usuarios - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Gestionar usuarios</h2>
        <p>Visualiza, modifica y elimina cuentas de usuario</p>
    </div>
</section>

<div class="container contenido-pagina">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    <div class="card card-custom">
        <div class="card-body">
            <h4 class="mb-3">Listado de usuarios</h4>

            @if(count($usuarios) > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Fecha registro</th>
                                <th>Tipo</th>
                                <th>Activo</th>
                                <th>Actualizar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->idUsuario }}</td>
                                    <td>{{ $usuario->nombre }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->fechaRegistro }}</td>

                                    <td>
                                        <form id="form-usuario-{{ $usuario->idUsuario }}"
                                            method="POST"
                                            action="{{ route('admin.usuarios.actualizar', $usuario->idUsuario) }}">
                                            @csrf
                                            @method('PUT')

                                            <select name="tipoUsuario" class="form-select form-select-sm">
                                                <option value="registrado" {{ $usuario->tipoUsuario === 'registrado' ? 'selected' : '' }}>
                                                    registrado
                                                </option>
                                                <option value="admin" {{ $usuario->tipoUsuario === 'admin' ? 'selected' : '' }}>
                                                    admin
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    <td>
                                        <select name="activo"
                                                form="form-usuario-{{ $usuario->idUsuario }}"
                                                class="form-select form-select-sm">
                                            <option value="1" {{ (int) $usuario->activo === 1 ? 'selected' : '' }}>
                                                Sí
                                            </option>
                                            <option value="0" {{ (int) $usuario->activo === 0 ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>
                                    </td>

                                    <td>
                                        <button type="submit"
                                                form="form-usuario-{{ $usuario->idUsuario }}"
                                                class="btn btn-sm btn-outline-primary">
                                            Guardar
                                        </button>
                                    </td>

                                    <td>
                                        @if((int) $usuario->idUsuario !== (int) session('usuario.idUsuario'))
                                            <form method="POST"
                                                action="{{ route('admin.usuarios.eliminar', $usuario->idUsuario) }}"
                                                onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Tu cuenta</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    No hay usuarios registrados.
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver al panel admin</a>
    </div>
</div>
@endsection