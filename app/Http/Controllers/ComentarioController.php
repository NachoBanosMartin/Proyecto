<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function guardar(Request $request)
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        $request->validate([
            'idLocalizacion' => 'required|integer',
            'idProduccion' => 'required|integer',
            'contenido' => 'required'
        ]);

        $comentario = new Comentario();
        $comentario->idUsuario = session('usuario.idUsuario');
        $comentario->idLocalizacion = $request->idLocalizacion;
        $comentario->contenido = $request->contenido;
        $comentario->fechaPublicacion = now();
        $comentario->save();

        return redirect()->route('localizacion.show', [
            'idProduccion' => $request->idProduccion,
            'idLocalizacion' => $request->idLocalizacion
        ])->with('success', 'Comentario publicado correctamente.');
    }
}