<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Favorito;
use App\Models\ProduccionLocalizacion;

class LocalizacionController extends Controller
{
    public function show($idProduccion, $idLocalizacion)
    {
        // Se comprueba que la producción y la localización estén realmente relacionadas
        $relacion = ProduccionLocalizacion::with(['produccion', 'localizacion'])
            ->where('idProduccion', $idProduccion)
            ->where('idLocalizacion', $idLocalizacion)
            ->first();

        if (!$relacion || !$relacion->produccion || !$relacion->localizacion) {
            abort(404);
        }

        // Se agrupan los datos de producción y localización en un solo objeto para simplificar la vista
        $detalle = (object) [
            'idProduccion' => $relacion->produccion->idProduccion,
            'titulo' => $relacion->produccion->titulo,
            'tipoProduccion' => $relacion->produccion->tipoProduccion,
            'sinopsis' => $relacion->produccion->sinopsis,
            'anioEstreno' => $relacion->produccion->anioEstreno,
            'idLocalizacion' => $relacion->localizacion->idLocalizacion,
            'nombreLocalizacion' => $relacion->localizacion->nombre,
            'municipio' => $relacion->localizacion->municipio,
            'provincia' => $relacion->localizacion->provincia,
            'latitud' => $relacion->localizacion->latitud,
            'longitud' => $relacion->localizacion->longitud,
            'imagen_url' => $relacion->localizacion->imagen_url
        ];

        $comentarios = Comentario::with('usuario')
            ->where('idLocalizacion', $idLocalizacion)
            ->orderByDesc('fechaPublicacion')
            ->get();

        // Si el usuario ha iniciado sesión, se comprueba si ya tiene guardada esta localización
        $esFavorito = false;

        if (session('usuario')) {
            $esFavorito = Favorito::where('idUsuario', session('usuario.idUsuario'))
                ->where('idLocalizacion', $idLocalizacion)
                ->exists();
        }

        return view('localizaciones.show', compact('detalle', 'comentarios', 'esFavorito'));
    }
}