<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduccionLocalizacion extends Model
{
    protected $table = 'produccion_localizacion';
    protected $primaryKey = 'idProduccionLocalizacion';
    public $timestamps = false;

    protected $fillable = [
        'idProduccion',
        'idLocalizacion'
    ];

    public function produccion()
    {
        return $this->belongsTo(Produccion::class, 'idProduccion', 'idProduccion');
    }

    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class, 'idLocalizacion', 'idLocalizacion');
    }
}