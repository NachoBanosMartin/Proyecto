<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Produccion;
use App\Models\Localizacion;
use App\Models\Comentario;
use App\Models\Favorito;

class AdminEstadisticaController extends Controller
{
    public function index()
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $totalUsuarios = Usuario::count();
        $totalProducciones = Produccion::count();
        $totalLocalizaciones = Localizacion::count();
        $totalComentarios = Comentario::count();
        $totalFavoritos = Favorito::count();

        $producciones = Produccion::with('produccionLocalizaciones')
            ->orderBy('titulo')
            ->get();

        $localizacionesComentarios = Localizacion::with('comentarios')
            ->orderBy('nombre')
            ->get();

        $localizacionesFavoritos = Localizacion::with('favoritos')
            ->orderBy('nombre')
            ->get();

        return view('admin.estadisticas', compact(
            'totalUsuarios',
            'totalProducciones',
            'totalLocalizaciones',
            'totalComentarios',
            'totalFavoritos',
            'producciones',
            'localizacionesComentarios',
            'localizacionesFavoritos'
        ));
    }
}