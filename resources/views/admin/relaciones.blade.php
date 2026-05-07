@extends('layouts.app')

@section('title', 'Administrar relaciones - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Administrar relaciones</h2>
        <p>Relaciona producciones con localizaciones</p>
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
            <h4 class="mb-3">Nueva relación</h4>

            <form method="POST" action="{{ route('admin.relaciones.guardar') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Producción</label>
                    <select name="idProduccion" class="form-select" required>
                        <option value="">Selecciona una producción</option>
                        @foreach($producciones as $produccion)
                            <option value="{{ $produccion->idProduccion }}">
                                {{ $produccion->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Localización</label>
                    <select name="idLocalizacion" class="form-select" required>
                        <option value="">Selecciona una localización</option>
                        @foreach($localizaciones as $localizacion)
                            <option value="{{ $localizacion->idLocalizacion }}">
                                {{ $localizacion->nombre }} - {{ $localizacion->municipio }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-grey-custom">Relacionar</button>
            </form>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <h4 class="mb-3">Relaciones existentes</h4>

            @if(count($relaciones) > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producción</th>
                                <th>Localización</th>
                                <th>Municipio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($relaciones as $relacion)
                                @if($relacion->produccion && $relacion->localizacion)
                                    <tr>
                                        <td>{{ $relacion->idProduccionLocalizacion }}</td>
                                        <td>{{ $relacion->produccion->titulo }}</td>
                                        <td>{{ $relacion->localizacion->nombre }}</td>
                                        <td>{{ $relacion->localizacion->municipio }}</td>
                                        <td>
                                            <form method="POST"
                                                  action="{{ route('admin.relaciones.eliminar', $relacion->idProduccionLocalizacion) }}"
                                                  onsubmit="return confirm('¿Seguro que quieres eliminar esta relación?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    No hay relaciones registradas.
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver al panel admin</a>
    </div>
</div>
@endsection