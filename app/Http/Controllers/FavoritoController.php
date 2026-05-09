<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function index()
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        $favoritos = Favorito::with('localizacion.produccionLocalizaciones.produccion')
            ->where('idUsuario', session('usuario.idUsuario'))
            ->orderByDesc('fecha')
            ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    public function toggle(Request $request, $idLocalizacion)
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        $idUsuario = session('usuario.idUsuario');
        $idProduccion = $request->input('idProduccion');

        $favorito = Favorito::where('idUsuario', $idUsuario)
            ->where('idLocalizacion', $idLocalizacion)
            ->first();

        // Si ya estaba guardado como favorito, se elimina. Si no, se añade

        if ($favorito) {
            $favorito->delete();
        } else {
            $nuevoFavorito = new Favorito();
            $nuevoFavorito->idUsuario = $idUsuario;
            $nuevoFavorito->idLocalizacion = $idLocalizacion;
            $nuevoFavorito->fecha = now();
            $nuevoFavorito->save();
        }

        // Si se viene del detalle de una producción, se vuelve a esa misma pantalla
        
        if ($idProduccion) {
            return redirect()->route('localizacion.show', [
                'idProduccion' => $idProduccion,
                'idLocalizacion' => $idLocalizacion
            ]);
        }

        return redirect()->route('favoritos.index');
    }
}