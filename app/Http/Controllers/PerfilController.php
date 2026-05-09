<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        $usuario = Usuario::find(session('usuario.idUsuario'));

        // Si el usuario de la sesión ya no existe se cierra la sesión

        if (!$usuario) {
            session()->forget('usuario');
            return redirect()->route('login');
        }

        return view('perfil.index', compact('usuario'));
    }

    public function actualizar(Request $request)
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        $idUsuario = session('usuario.idUsuario');

        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $idUsuario . ',idUsuario',
            'password_actual' => 'nullable',
            'password_nueva' => 'nullable|min:6|max:255',
            'password_nueva_2' => 'nullable|same:password_nueva'
        ]);

        $usuario = Usuario::find($idUsuario);

        if (!$usuario) {
            session()->forget('usuario');
            return redirect()->route('login');
        }

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;

        // La contraseña solo se cambia si el usuario relllena alguno de los campos

        if ($request->password_actual || $request->password_nueva || $request->password_nueva_2) {

            // Para cambiar la contraseña se exije la actual y repetir la nueva
            
            if (!$request->password_actual || !$request->password_nueva || !$request->password_nueva_2) {
                return back()->withErrors([
                    'password_actual' => 'Si quieres cambiar la contraseña, debes rellenar los tres campos.'
                ])->withInput();
            }

            if ($usuario->password !== hash('sha256', $request->password_actual)) {
                return back()->withErrors([
                    'password_actual' => 'La contraseña actual no es correcta.'
                ])->withInput();
            }

            $usuario->password = hash('sha256', $request->password_nueva);
        }

        $usuario->save();

        session([
            'usuario' => [
                'idUsuario' => $usuario->idUsuario,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'tipoUsuario' => $usuario->tipoUsuario
            ]
        ]);

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function eliminar(Request $request)
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        $request->validate([
            'confirmacion' => 'required',
            'password_eliminar' => 'required'
        ]);

        if ($request->confirmacion !== 'ELIMINAR') {
            return back()->withErrors([
                'confirmacion' => 'Debes escribir ELIMINAR para confirmar.'
            ]);
        }

        $usuario = Usuario::find(session('usuario.idUsuario'));

        if (!$usuario) {
            session()->forget('usuario');
            return redirect()->route('login');
        }

        // No se permite borra una cuenta administradora desde el perfil normal

        if ($usuario->tipoUsuario === 'admin') {
            return back()->withErrors([
                'password_eliminar' => 'No puedes eliminar una cuenta administradora desde esta vista.'
            ]);
        }

        if ($usuario->password !== hash('sha256', $request->password_eliminar)) {
            return back()->withErrors([
                'password_eliminar' => 'La contraseña no es correcta.'
            ]);
        }

        // Se eliminan primero los datos relacionados y después la cuenta
        
        $usuario->favoritos()->delete();
        $usuario->comentarios()->delete();
        $usuario->delete();

        session()->forget('usuario');

        return redirect()->route('inicio')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
    }
}