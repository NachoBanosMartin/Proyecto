@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>Iniciar sesión</h2>
        <p>Accede a tu cuenta</p>
    </div>
</section>

<div class="container contenido-pagina">
    <div class="formulario-centrado">
        <div class="formulario-col">
            <div class="card card-custom">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.autenticar') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-grey-custom">Entrar</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <p class="mb-0">
                            ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection