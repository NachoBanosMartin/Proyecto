<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'fechaRegistro',
        'activo',
        'tipoUsuario'
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idUsuario', 'idUsuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'idUsuario', 'idUsuario');
    }
}