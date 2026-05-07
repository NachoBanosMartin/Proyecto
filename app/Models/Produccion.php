<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table = 'producciones';
    protected $primaryKey = 'idProduccion';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'tipoProduccion',
        'sinopsis',
        'anioEstreno',
        'imagen'
    ];

    public function produccionLocalizaciones()
    {
        return $this->hasMany(ProduccionLocalizacion::class, 'idProduccion', 'idProduccion');
    }
}