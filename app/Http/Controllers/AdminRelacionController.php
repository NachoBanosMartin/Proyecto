<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Localizacion;
use App\Models\ProduccionLocalizacion;
use Illuminate\Http\Request;

class AdminRelacionController extends Controller
{
    public function index()
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $producciones = Produccion::orderBy('titulo')->get();
        $localizaciones = Localizacion::orderBy('nombre')->get();

        $relaciones = ProduccionLocalizacion::with(['produccion', 'localizacion'])
            ->orderBy('idProduccion')
            ->get();

        return view('admin.relaciones', compact('producciones', 'localizaciones', 'relaciones'));
    }

    public function guardar(Request $request)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $request->validate([
            'idProduccion' => 'required|integer',
            'idLocalizacion' => 'required|integer'
        ]);

        $existe = ProduccionLocalizacion::where('idProduccion', $request->idProduccion)
            ->where('idLocalizacion', $request->idLocalizacion)
            ->first();

        if ($existe) {
            return redirect()->route('admin.relaciones')
                ->withErrors(['error' => 'Esa relación ya existe.']);
        }

        $relacion = new ProduccionLocalizacion();
        $relacion->idProduccion = $request->idProduccion;
        $relacion->idLocalizacion = $request->idLocalizacion;
        $relacion->save();

        return redirect()->route('admin.relaciones')->with('success', 'Relación creada correctamente.');
    }

    public function eliminar($idProduccionLocalizacion)
    {
        if (!session('usuario') || session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        $relacion = ProduccionLocalizacion::find($idProduccionLocalizacion);

        if (!$relacion) {
            return redirect()->route('admin.relaciones')
                ->withErrors(['error' => 'Relación no encontrada.']);
        }

        $relacion->delete();

        return redirect()->route('admin.relaciones')->with('success', 'Relación eliminada correctamente.');
    }
}