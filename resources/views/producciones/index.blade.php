@extends('layouts.app')

@section('title', $tituloPagina . ' - Pantalla Extremeña')

@section('content')
<section class="hero-verde">
    <div class="container">
        <h2>{{ $tituloPagina }} rodadas en Extremadura</h2>
        <p>Explora las localizaciones en el mapa</p>
    </div>
</section>

<div class="container contenido-pagina">
    <div class="card card-custom mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('producciones.index', $tipo) }}" class="row g-2">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar por título"
                        value="{{ $buscar }}"
                    >
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-grey-custom">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mapa-card">
        <div id="map" style="height: 600px;"></div>
    </div>

    @if(count($resultados) === 0)
        <div class="alert alert-warning mt-4 mb-0">
            No se han encontrado resultados para esa búsqueda.
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">
            Volver al inicio
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const resultados = @json($resultados, JSON_UNESCAPED_UNICODE);
    const map = L.map('map');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const localizaciones = {};

    resultados.forEach(function(item) {
        const key = item.idLocalizacion;

        if (!localizaciones[key]) {
            localizaciones[key] = {
                idLocalizacion: item.idLocalizacion,
                nombre: item.nombreLocalizacion,
                municipio: item.municipio,
                provincia: item.provincia,
                imagen_url: item.imagen_url,
                lat: parseFloat(item.latitud),
                lng: parseFloat(item.longitud),
                producciones: []
            };
        }

        localizaciones[key].producciones.push({
            id: item.idProduccion,
            titulo: item.titulo
        });
    });

    Object.values(localizaciones).forEach(function(loc) {
        if (!isNaN(loc.lat) && !isNaN(loc.lng)) {
            let contenido = `<div style="min-width:220px; max-width:220px;">`;

            if (loc.imagen_url) {
                contenido += `<img src="${loc.imagen_url}" alt="${loc.nombre}" class="popup-img" style="height:120px;">`;
            }

            contenido += `
                <h6 style="margin-bottom:6px">${loc.nombre}</h6>
                <p style="margin-bottom:8px; font-size:14px; color:#666;">${loc.municipio} (${loc.provincia})</p>
                <ul style="padding-left:18px; margin:0;">
            `;

            loc.producciones.forEach(function(p) {
                contenido += `
                    <li>
                        <a href="/localizacion/${p.id}/${loc.idLocalizacion}">
                            ${p.titulo}
                        </a>
                    </li>
                `;
            });

            contenido += `</ul></div>`;

            L.marker([loc.lat, loc.lng]).addTo(map).bindPopup(contenido);
        }
    });

    const bounds = [];

    Object.values(localizaciones).forEach(function(loc) {
        if (!isNaN(loc.lat) && !isNaN(loc.lng)) {
            bounds.push([loc.lat, loc.lng]);
        }
    });

    if (bounds.length === 1) {
        map.setView(bounds[0], 12);
    } else if (bounds.length > 1) {
        map.fitBounds(bounds);
    } else {
        map.setView([39.2, -6.1], 8);
    }
</script>
@endsection