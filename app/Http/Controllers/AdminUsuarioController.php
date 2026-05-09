<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminUsuarioController extends Controller
{
    public function index()
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $usuarios = Usuario::orderBy('nombre')->get();

        return view('admin.usuarios', compact('usuarios'));
    }

    public function actualizar(Request $request, $idUsuario)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $request->validate([
            'tipoUsuario' => 'required',
            'activo' => 'required|integer'
        ]);

        $usuario = Usuario::find($idUsuario);

        if (!$usuario) {
            return redirect()->route('admin.usuarios')
                ->withErrors(['error' => 'Usuario no encontrado.']);
        }

        $usuario->tipoUsuario = $request->tipoUsuario;
        $usuario->activo = $request->activo;
        $usuario->save();

        return redirect()->route('admin.usuarios')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function eliminar($idUsuario)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        // Un administrador no puede eliminar su propia cuenta desde el panel
        
        if ((int) $idUsuario === (int) session('usuario.idUsuario')) {
            return redirect()->route('admin.usuarios')
                ->withErrors(['error' => 'No puedes eliminar tu propia cuenta de administrador.']);
        }

        $usuario = Usuario::find($idUsuario);

        if (!$usuario) {
            return redirect()->route('admin.usuarios')
                ->withErrors(['error' => 'Usuario no encontrado.']);
        }

        $usuario->favoritos()->delete();
        $usuario->comentarios()->delete();
        $usuario->delete();

        return redirect()->route('admin.usuarios')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}