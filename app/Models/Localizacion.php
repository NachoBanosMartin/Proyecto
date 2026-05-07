<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacion extends Model
{
    protected $table = 'localizaciones';
    protected $primaryKey = 'idLocalizacion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'municipio',
        'provincia',
        'latitud',
        'longitud',
        'imagen_url'
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idLocalizacion', 'idLocalizacion');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'idLocalizacion', 'idLocalizacion');
    }

    public function produccionLocalizaciones()
    {
        return $this->hasMany(ProduccionLocalizacion::class, 'idLocalizacion', 'idLocalizacion');
    }
}