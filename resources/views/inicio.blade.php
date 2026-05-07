@extends('layouts.app')

@section('title', 'Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h1 class="display-4">¡Bienvenido a<br>Pantalla Extremeña!</h1>
        <p>Explora Extremadura a través del cine</p>
    </div>
</section>

@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success mb-0">
            {{ session('success') }}
        </div>
    </div>
@endif

<section class="bloque-principal">
    <div class="container">
        <div class="opciones-cine-row">
            <div class="opcion-cine-col">
                <a href="{{ route('producciones.index', 'pelicula') }}" class="opcion-cine">
                    <img 
                        src="{{ asset('img/clapper.png') }}" 
                        alt="Películas" 
                        class="clapper-img"
                    >
                </a>

                <p class="texto-opcion-cine">Películas</p>
            </div>

            <div class="opcion-cine-col">
                <a href="{{ route('producciones.index', 'serie') }}" class="opcion-cine">
                    <img 
                        src="{{ asset('img/clapper.png') }}" 
                        alt="Series" 
                        class="clapper-img"
                    >
                </a>

                <p class="texto-opcion-cine">Series</p>
            </div>
        </div>
    </div>
</section>
@endsection