<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use Illuminate\Http\Request;

class AdminProduccionController extends Controller
{
    public function index()
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $producciones = Produccion::orderBy('titulo')->get();

        return view('admin.producciones', compact('producciones'));
    }

    public function guardar(Request $request)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $request->validate([
            'titulo' => 'required|max:200',
            'tipoProduccion' => 'required',
            'sinopsis' => 'required',
            'anioEstreno' => 'required|integer'
        ]);

        $produccion = new Produccion();
        $produccion->titulo = $request->titulo;
        $produccion->tipoProduccion = $request->tipoProduccion;
        $produccion->sinopsis = $request->sinopsis;
        $produccion->anioEstreno = $request->anioEstreno;
        $produccion->save();

        return redirect()->route('admin.producciones')->with('success', 'Producción creada correctamente.');
    }

    public function editar($idProduccion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $producciones = Produccion::orderBy('titulo')->get();
        $produccionEditar = Produccion::find($idProduccion);

        if (!$produccionEditar) {
            return redirect()->route('admin.producciones')->withErrors(['error' => 'Producción no encontrada.']);
        }

        return view('admin.producciones', compact('producciones', 'produccionEditar'));
    }

    public function actualizar(Request $request, $idProduccion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $request->validate([
            'titulo' => 'required|max:200',
            'tipoProduccion' => 'required',
            'sinopsis' => 'required',
            'anioEstreno' => 'required|integer'
        ]);

        $produccion = Produccion::find($idProduccion);

        if (!$produccion) {
            return redirect()->route('admin.producciones')->withErrors(['error' => 'Producción no encontrada.']);
        }

        $produccion->titulo = $request->titulo;
        $produccion->tipoProduccion = $request->tipoProduccion;
        $produccion->sinopsis = $request->sinopsis;
        $produccion->anioEstreno = $request->anioEstreno;
        $produccion->save();

        return redirect()->route('admin.producciones')->with('success', 'Producción actualizada correctamente.');
    }

    public function eliminar($idProduccion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $produccion = Produccion::find($idProduccion);

        if (!$produccion) {
            return redirect()->route('admin.producciones')->withErrors(['error' => 'Producción no encontrada.']);
        }

        $produccion->delete();

        return redirect()->route('admin.producciones')->with('success', 'Producción eliminada correctamente.');
    }
}