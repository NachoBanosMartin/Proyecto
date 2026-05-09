@extends('layouts.app')

@section('title', 'Panel de Administración - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Panel de Administración</h2>
        <p>Gestiona contenidos, usuarios y estadísticas</p>
    </div>
</section>

<div class="container contenido-pagina">
    <div class="admin-grid">

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h4>Producciones</h4>
                    <p>Añadir, editar y eliminar películas y series.</p>
                    <a href="{{ route('admin.producciones') }}" class="btn btn-grey-custom">Gestionar producciones</a>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h4>Localizaciones</h4>
                    <p>Añadir, editar y eliminar localizaciones.</p>
                    <a href="{{ route('admin.localizaciones') }}" class="btn btn-grey-custom">Gestionar localizaciones</a>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h4>Relaciones</h4>
                    <p>Relacionar producciones con localizaciones.</p>
                    <a href="{{ route('admin.relaciones') }}" class="btn btn-grey-custom">Gestionar relaciones</a>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h4>Comentarios</h4>
                    <p>Revisar y eliminar comentarios de usuarios.</p>
                    <a href="{{ route('admin.comentarios') }}" class="btn btn-grey-custom">Gestionar comentarios</a>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h4>Usuarios</h4>
                    <p>Visualizar, editar o eliminar cuentas.</p>
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-grey-custom">Gestionar usuarios</a>
                </div>
            </div>
        </div>

        <div>
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h4>Estadísticas</h4>
                    <p>Consultar métricas de la plataforma.</p>
                    <a href="{{ route('admin.estadisticas') }}" class="btn btn-grey-custom">Ver estadísticas</a>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-4">
        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">Volver al inicio</a>
    </div>
</div>
@endsection