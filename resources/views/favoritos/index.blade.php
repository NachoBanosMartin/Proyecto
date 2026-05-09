@extends('layouts.app')

@section('title', 'Mis favoritos - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Mis favoritos</h2>
        <p>Aquí puedes ver tus localizaciones guardadas</p>
    </div>
</section>

<div class="container contenido-pagina">
    @if(count($favoritos) > 0)
        <div class="favoritos-grid">
            @foreach($favoritos as $favorito)
                @php
                    $localizacion = $favorito->localizacion;
                    $relacion = $localizacion?->produccionLocalizaciones->first();
                    $produccion = $relacion?->produccion;
                @endphp

                @if($localizacion && $produccion)
                    <div>
                        <div class="card h-100 shadow-sm">
                            <img
                                src="{{ $localizacion->imagen_url }}"
                                class="card-img-top favorito-card-img"
                                alt="{{ $localizacion->nombre }}"
                            >

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $produccion->titulo }}</h5>

                                <p class="mb-2 text-muted">
                                    {{ $localizacion->nombre }}
                                </p>

                                <p class="small text-muted">
                                    {{ $localizacion->municipio }} ({{ $localizacion->provincia }})
                                </p>

                                <p class="card-text">
                                    {{ $produccion->sinopsis }}
                                </p>

                                <p class="mb-2">
                                    <strong>Año:</strong> {{ $produccion->anioEstreno }}
                                </p>

                                <p class="small text-muted">
                                    Guardado el {{ $favorito->fecha }}
                                </p>

                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('localizacion.show', ['idProduccion' => $produccion->idProduccion, 'idLocalizacion' => $localizacion->idLocalizacion]) }}"
                                    class="btn btn-primary">
                                        Ver detalle
                                    </a>

                                    <form method="POST" action="{{ route('favoritos.toggle', $localizacion->idLocalizacion) }}">
                                        @csrf
                                        <input type="hidden" name="idProduccion" value="{{ $produccion->idProduccion }}">
                                        <button type="submit" class="btn btn-outline-danger">
                                            Quitar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Todavía no tienes favoritos guardados.
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">Volver al inicio</a>
    </div>
</div>
@endsection