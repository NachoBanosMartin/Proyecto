<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'password' => 'required|min:6|max:255'
        ]);

        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = hash('sha256', $request->password);
        $usuario->fechaRegistro = now();
        $usuario->activo = 1;
        $usuario->tipoUsuario = 'registrado';
        $usuario->save();

        return redirect()->route('registro')->with('success', 'Usuario registrado correctamente.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Correo o contraseña incorrectos.'
            ])->withInput();
        }

        if ((int) $usuario->activo !== 1) {
            return back()->withErrors([
                'email' => 'Tu cuenta no está activa.'
            ])->withInput();
        }

        $passwordHash = hash('sha256', $request->password);

        if ($usuario->password !== $passwordHash) {
            return back()->withErrors([
                'email' => 'Correo o contraseña incorrectos.'
            ])->withInput();
        }

        session([
            'usuario' => [
                'idUsuario' => $usuario->idUsuario,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'tipoUsuario' => $usuario->tipoUsuario
            ]
        ]);

        return redirect()->route('inicio');
    }

    public function logout()
    {
        session()->forget('usuario');
        return redirect()->route('inicio');
    }
}