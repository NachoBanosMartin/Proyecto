<?php

namespace App\Http\Controllers;

use App\Models\Localizacion;
use Illuminate\Http\Request;

class AdminLocalizacionController extends Controller
{
    public function index()
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $localizaciones = Localizacion::orderBy('nombre')->get();

        return view('admin.localizaciones', compact('localizaciones'));
    }

    public function guardar(Request $request)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $request->validate([
            'nombre' => 'required|max:150',
            'municipio' => 'required|max:150',
            'provincia' => 'required|max:150',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'imagen_url' => 'required|max:500'
        ]);

        $localizacion = new Localizacion();
        $localizacion->nombre = $request->nombre;
        $localizacion->municipio = $request->municipio;
        $localizacion->provincia = $request->provincia;
        $localizacion->latitud = $request->latitud;
        $localizacion->longitud = $request->longitud;
        $localizacion->imagen_url = $request->imagen_url;
        $localizacion->save();

        return redirect()->route('admin.localizaciones')->with('success', 'Localización creada correctamente.');
    }

    public function editar($idLocalizacion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $localizaciones = Localizacion::orderBy('nombre')->get();
        $localizacionEditar = Localizacion::find($idLocalizacion);

        if (!$localizacionEditar) {
            return redirect()->route('admin.localizaciones')->withErrors(['error' => 'Localización no encontrada.']);
        }

        return view('admin.localizaciones', compact('localizaciones', 'localizacionEditar'));
    }

    public function actualizar(Request $request, $idLocalizacion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $request->validate([
            'nombre' => 'required|max:150',
            'municipio' => 'required|max:150',
            'provincia' => 'required|max:150',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'imagen_url' => 'required|max:500'
        ]);

        $localizacion = Localizacion::find($idLocalizacion);

        if (!$localizacion) {
            return redirect()->route('admin.localizaciones')->withErrors(['error' => 'Localización no encontrada.']);
        }

        $localizacion->nombre = $request->nombre;
        $localizacion->municipio = $request->municipio;
        $localizacion->provincia = $request->provincia;
        $localizacion->latitud = $request->latitud;
        $localizacion->longitud = $request->longitud;
        $localizacion->imagen_url = $request->imagen_url;
        $localizacion->save();

        return redirect()->route('admin.localizaciones')->with('success', 'Localización actualizada correctamente.');
    }

    public function eliminar($idLocalizacion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $localizacion = Localizacion::find($idLocalizacion);

        if (!$localizacion) {
            return redirect()->route('admin.localizaciones')->withErrors(['error' => 'Localización no encontrada.']);
        }

        $localizacion->delete();

        return redirect()->route('admin.localizaciones')->with('success', 'Localización eliminada correctamente.');
    }
}