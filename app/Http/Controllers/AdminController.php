<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        if (session('usuario.tipoUsuario') !== 'admin') {
            return redirect()->route('inicio');
        }

        return view('admin.index');
    }
}