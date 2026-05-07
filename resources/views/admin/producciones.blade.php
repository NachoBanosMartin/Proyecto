@extends('layouts.app')

@section('title', 'Administrar producciones - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Administrar producciones</h2>
        <p>Añadir, editar y eliminar películas y series</p>
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
                @isset($produccionEditar)
                    Editar producción
                @else
                    Nueva producción
                @endisset
            </h4>

            @isset($produccionEditar)
                <form method="POST" action="{{ route('admin.producciones.actualizar', $produccionEditar->idProduccion) }}">
                    @csrf
                    @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.producciones.guardar') }}">
                    @csrf
            @endisset

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required
                           value="{{ old('titulo', $produccionEditar->titulo ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de producción</label>
                    <select name="tipoProduccion" class="form-select" required>
                        <option value="">Selecciona una opción</option>
                        <option value="pelicula" {{ old('tipoProduccion', $produccionEditar->tipoProduccion ?? '') === 'pelicula' ? 'selected' : '' }}>
                            Película
                        </option>
                        <option value="serie" {{ old('tipoProduccion', $produccionEditar->tipoProduccion ?? '') === 'serie' ? 'selected' : '' }}>
                            Serie
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="sinopsis" class="form-control" rows="5" required>{{ old('sinopsis', $produccionEditar->sinopsis ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Año de estreno</label>
                    <input type="number" name="anioEstreno" class="form-control" required
                           value="{{ old('anioEstreno', $produccionEditar->anioEstreno ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre de imagen</label>
                    <input type="text" name="imagen" class="form-control" required
                           placeholder="ejemplo: juego-de-tronos-arco-estrella.jpg"
                           value="{{ old('imagen', $produccionEditar->imagen ?? '') }}">
                </div>

                <button type="submit" class="btn btn-grey-custom">
                    @isset($produccionEditar)
                        Actualizar producción
                    @else
                        Crear producción
                    @endisset
                </button>

                @isset($produccionEditar)
                    <a href="{{ route('admin.producciones') }}" class="btn btn-outline-secondary">Cancelar</a>
                @endisset

            </form>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <h4 class="mb-3">Listado de producciones</h4>

            @if(count($producciones) > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Año</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($producciones as $produccion)
                                <tr>
                                    <td>{{ $produccion->idProduccion }}</td>
                                    <td>
                                        <img src="https://pantalla-extremena-img.s3.us-east-1.amazonaws.com/{{ $produccion->imagen }}"
                                             alt="{{ $produccion->titulo }}"
                                             style="width: 90px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    </td>
                                    <td>{{ $produccion->titulo }}</td>
                                    <td>{{ $produccion->tipoProduccion }}</td>
                                    <td>{{ $produccion->anioEstreno }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.producciones.editar', $produccion->idProduccion) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Editar
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.producciones.eliminar', $produccion->idProduccion) }}"
                                                  onsubmit="return confirm('¿Seguro que quieres eliminar esta producción?');">
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
                    No hay producciones registradas.
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver al panel admin</a>
    </div>
</div>
@endsection