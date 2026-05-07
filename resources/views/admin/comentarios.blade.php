@extends('layouts.app')

@section('title', 'Administrar comentarios - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Administrar comentarios</h2>
        <p>Revisa y elimina comentarios de usuarios</p>
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
            <h4 class="mb-3">Listado de comentarios</h4>

            @if(count($comentarios) > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Localización</th>
                                <th>Municipio</th>
                                <th>Comentario</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($comentarios as $comentario)
                                <tr>
                                    <td>{{ $comentario->idComentario }}</td>

                                    <td>
                                        {{ $comentario->usuario ? $comentario->usuario->nombre : 'Usuario eliminado' }}
                                    </td>

                                    <td>
                                        {{ $comentario->usuario ? $comentario->usuario->email : '-' }}
                                    </td>

                                    <td>
                                        {{ $comentario->localizacion ? $comentario->localizacion->nombre : 'Localización eliminada' }}
                                    </td>

                                    <td>
                                        {{ $comentario->localizacion ? $comentario->localizacion->municipio : '-' }}
                                    </td>

                                    <td>{!! nl2br(e($comentario->contenido)) !!}</td>

                                    <td>{{ $comentario->fechaPublicacion }}</td>

                                    <td>
                                        <form method="POST"
                                              action="{{ route('admin.comentarios.eliminar', $comentario->idComentario) }}"
                                              onsubmit="return confirm('¿Seguro que quieres eliminar este comentario?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    No hay comentarios registrados.
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver al panel admin</a>
    </div>
</div>
@endsection