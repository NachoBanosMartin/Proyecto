<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';
    protected $primaryKey = 'idComentario';
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'idLocalizacion',
        'contenido',
        'fechaPublicacion'
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