@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Crear cuenta</h2>
        <p>Regístrate para guardar favoritos y comentar localizaciones</p>
    </div>
</section>

<div class="container contenido-pagina">
    <div class="formulario-centrado">
        <div class="formulario-col">
            <div class="card card-custom">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Registro</h2>

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

                    <form method="POST" action="{{ route('registro.guardar') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-dark-custom w-100">
                            Registrarse
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('inicio') }}">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection