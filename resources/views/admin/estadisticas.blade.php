@extends('layouts.app')

@section('title', 'Estadísticas - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Estadísticas de la plataforma</h2>
        <p>Informes y métricas de uso actuales</p>
    </div>
</section>

<div class="container contenido-pagina">

    <div class="estadisticas-grid mb-4">
        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5>Total usuarios</h5>
                    <p class="display-6 mb-0">{{ $totalUsuarios }}</p>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5>Total producciones</h5>
                    <p class="display-6 mb-0">{{ $totalProducciones }}</p>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5>Total localizaciones</h5>
                    <p class="display-6 mb-0">{{ $totalLocalizaciones }}</p>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5>Total comentarios</h5>
                    <p class="display-6 mb-0">{{ $totalComentarios }}</p>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5>Total favoritos</h5>
                    <p class="display-6 mb-0">{{ $totalFavoritos }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-3">Producciones con más localizaciones</h4>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producción</th>
                            <th>Total localizaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($producciones as $produccion)
                            <tr>
                                <td>{{ $produccion->titulo }}</td>
                                <td>{{ count($produccion->produccionLocalizaciones) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-3">Localizaciones con más comentarios</h4>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Localización</th>
                            <th>Municipio</th>
                            <th>Total comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($localizacionesComentarios as $localizacion)
                            <tr>
                                <td>{{ $localizacion->nombre }}</td>
                                <td>{{ $localizacion->municipio }}</td>
                                <td>{{ count($localizacion->comentarios) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-3">Localizaciones más guardadas en favoritos</h4>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Localización</th>
                            <th>Municipio</th>
                            <th>Total favoritos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($localizacionesFavoritos as $localizacion)
                            <tr>
                                <td>{{ $localizacion->nombre }}</td>
                                <td>{{ $localizacion->municipio }}</td>
                                <td>{{ count($localizacion->favoritos) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver al panel admin</a>
    </div>
</div>
@endsection