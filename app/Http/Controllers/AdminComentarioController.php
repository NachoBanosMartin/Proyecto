<?php

namespace App\Http\Controllers;

use App\Models\Comentario;

class AdminComentarioController extends Controller
{
    public function index()
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $comentarios = Comentario::with(['usuario', 'localizacion'])
            ->orderByDesc('fechaPublicacion')
            ->get();

        return view('admin.comentarios', compact('comentarios'));
    }

    public function eliminar($idComentario)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $comentario = Comentario::find($idComentario);

        if (!$comentario) {
            return redirect()->route('admin.comentarios')
                ->withErrors(['error' => 'Comentario no encontrado.']);
        }

        $comentario->delete();

        return redirect()->route('admin.comentarios')
            ->with('success', 'Comentario eliminado correctamente.');
    }
}