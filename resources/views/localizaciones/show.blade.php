@extends('layouts.app')

@section('title', $detalle->titulo . ' - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>{{ $detalle->titulo }}</h2>
        <p>{{ $detalle->tipoProduccion }} · {{ $detalle->anioEstreno }}</p>
    </div>
</section>

<div class="container contenido-pagina">
    <div class="card card-custom mb-4">
        <div class="card-body">
            <div class="row g-4 align-items-start">
                <div class="col-lg-6">
                    @if(!empty($detalle->imagen_url))
                        <img
                            src="{{ $detalle->imagen_url }}"
                            alt="{{ $detalle->nombreLocalizacion }}"
                            class="img-fluid rounded mb-3"
                            style="width: 100%; max-height: 380px; object-fit: cover;"
                        >
                    @endif

                    <h4 class="mb-2">{{ $detalle->nombreLocalizacion }}</h4>

                    <p class="text-muted mb-3">
                        {{ $detalle->municipio }} ({{ $detalle->provincia }})
                    </p>

                    <p class="mb-3">
                        <strong>Sinopsis:</strong> {{ $detalle->sinopsis }}
                    </p>

                    @if(session('usuario'))
                        <form method="POST" action="{{ route('favoritos.toggle', $detalle->idLocalizacion) }}">
                            @csrf
                            <input type="hidden" name="idProduccion" value="{{ $detalle->idProduccion }}">

                            @if($esFavorito)
                                <button type="submit" class="btn btn-danger">Quitar de favoritos</button>
                            @else
                                <button type="submit" class="btn btn-grey-custom">Añadir a favoritos</button>
                            @endif
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-danger">
                            Inicia sesión para añadir a favoritos
                        </a>
                    @endif
                </div>

                <div class="col-lg-6">
                    <div id="map" style="height: 500px; border-radius: 10px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body">
            <h4 class="mb-3">Comentarios</h4>

            @if(session('usuario'))
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

                <form method="POST" action="{{ route('comentarios.guardar') }}" class="mb-4">
                    @csrf

                    <input type="hidden" name="idLocalizacion" value="{{ $detalle->idLocalizacion }}">
                    <input type="hidden" name="idProduccion" value="{{ $detalle->idProduccion }}">

                    <div class="mb-3">
                        <label for="contenido" class="form-label">Escribe tu comentario</label>
                        <textarea
                            name="contenido"
                            id="contenido"
                            class="form-control"
                            rows="4"
                            required
                            placeholder="Escribe aquí tu comentario..."
                        >{{ old('contenido') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-grey-custom">Publicar comentario</button>
                </form>
            @else
                <div class="alert alert-warning">
                    Debes <a href="{{ route('login') }}">iniciar sesión</a> para escribir comentarios.
                </div>
            @endif

            @if(count($comentarios) > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($comentarios as $comentario)
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $comentario->usuario->nombre }}</strong>
                                <span class="text-muted small">{{ $comentario->fechaPublicacion }}</span>
                            </div>
                            <p class="mb-0">{!! nl2br(e($comentario->contenido)) !!}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-0">Todavía no hay comentarios en esta localización.</p>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('producciones.index', $detalle->tipoProduccion) }}" class="btn btn-outline-secondary">
            Volver
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const lat = {{ (float) $detalle->latitud }};
    const lng = {{ (float) $detalle->longitud }};
    const nombre = @json($detalle->nombreLocalizacion, JSON_UNESCAPED_UNICODE);
    const municipio = @json($detalle->municipio, JSON_UNESCAPED_UNICODE);
    const provincia = @json($detalle->provincia, JSON_UNESCAPED_UNICODE);

    const map = L.map('map').setView([lat, lng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`<strong>${nombre}</strong><br>${municipio} (${provincia})`)
        .openPopup();
</script>
@endsection