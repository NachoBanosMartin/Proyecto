@extends('layouts.app')

@section('title', 'Administrar localizaciones - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Administrar localizaciones</h2>
        <p>Añadir, editar y eliminar localizaciones</p>
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

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-3">
                @isset($localizacionEditar)
                    Editar localización
                @else
                    Nueva localización
                @endisset
            </h4>

            @isset($localizacionEditar)
                <form method="POST" action="{{ route('admin.localizaciones.actualizar', $localizacionEditar->idLocalizacion) }}">
                    @csrf
                    @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.localizaciones.guardar') }}">
                    @csrf
            @endisset

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required
                           value="{{ old('nombre', $localizacionEditar->nombre ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Municipio</label>
                    <input type="text" name="municipio" class="form-control" required
                           value="{{ old('municipio', $localizacionEditar->municipio ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Provincia</label>
                    <input type="text" name="provincia" class="form-control" required
                           value="{{ old('provincia', $localizacionEditar->provincia ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Latitud</label>
                    <input type="text" name="latitud" class="form-control" required
                           value="{{ old('latitud', $localizacionEditar->latitud ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Longitud</label>
                    <input type="text" name="longitud" class="form-control" required
                           value="{{ old('longitud', $localizacionEditar->longitud ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">URL de imagen</label>
                    <input type="text" name="imagen_url" class="form-control" required
                           value="{{ old('imagen_url', $localizacionEditar->imagen_url ?? '') }}">
                </div>

                <button type="submit" class="btn btn-grey-custom">
                    @isset($localizacionEditar)
                        Actualizar localización
                    @else
                        Crear localización
                    @endisset
                </button>

                @isset($localizacionEditar)
                    <a href="{{ route('admin.localizaciones') }}" class="btn btn-outline-secondary">Cancelar</a>
                @endisset

            </form>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <h4 class="mb-3">Listado de localizaciones</h4>

            @if(count($localizaciones) > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Municipio</th>
                                <th>Provincia</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($localizaciones as $localizacion)
                                <tr>
                                    <td>{{ $localizacion->idLocalizacion }}</td>
                                    <td>
                                        <img src="{{ $localizacion->imagen_url }}"
                                             alt="{{ $localizacion->nombre }}"
                                             style="width: 90px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    </td>
                                    <td>{{ $localizacion->nombre }}</td>
                                    <td>{{ $localizacion->municipio }}</td>
                                    <td>{{ $localizacion->provincia }}</td>
                                    <td>{{ $localizacion->latitud }}</td>
                                    <td>{{ $localizacion->longitud }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.localizaciones.editar', $localizacion->idLocalizacion) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Editar
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.localizaciones.eliminar', $localizacion->idLocalizacion) }}"
                                                  onsubmit="return confirm('¿Seguro que quieres eliminar esta localización?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    No hay localizaciones registradas.
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver al panel admin</a>
    </div>
</div>
@endsection