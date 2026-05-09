<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    public function index(Request $request, $tipo)
    {
        // Solo se aceptan los 2 tipos de producción usados en la app

        if ($tipo !== 'pelicula' && $tipo !== 'serie') {
            abort(404);
        }

        $buscar = trim($request->input('buscar', ''));

        $producciones = Produccion::with('produccionLocalizaciones.localizacion')
            ->where('tipoProduccion', $tipo)

            // Si hay texto de busqueda se filtra por título
            
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where('titulo', 'like', '%' . $buscar . '%');
            })
            ->orderBy('titulo')
            ->get();

        // Se prepara un array para que js pueda pintar el mapa
        
        $resultados = [];

        foreach ($producciones as $produccion) {
            foreach ($produccion->produccionLocalizaciones as $pl) {
                if ($pl->localizacion) {
                    $resultados[] = [
                        'idProduccion' => $produccion->idProduccion,
                        'titulo' => $produccion->titulo,
                        'tipoProduccion' => $produccion->tipoProduccion,
                        'sinopsis' => $produccion->sinopsis,
                        'anioEstreno' => $produccion->anioEstreno,
                        'idLocalizacion' => $pl->localizacion->idLocalizacion,
                        'nombreLocalizacion' => $pl->localizacion->nombre,
                        'municipio' => $pl->localizacion->municipio,
                        'provincia' => $pl->localizacion->provincia,
                        'latitud' => $pl->localizacion->latitud,
                        'longitud' => $pl->localizacion->longitud,
                        'imagen_url' => $pl->localizacion->imagen_url
                    ];
                }
            }
        }

        $tituloPagina = $tipo === 'pelicula' ? 'Películas' : 'Series';

        return view('producciones.index', compact('resultados', 'tituloPagina', 'tipo', 'buscar'));
    }
}