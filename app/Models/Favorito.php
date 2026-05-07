<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'favoritos';
    protected $primaryKey = 'idFavorito';
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'idLocalizacion',
        'fecha'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }

    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class, 'idLocalizacion', 'idLocalizacion');
    }
}