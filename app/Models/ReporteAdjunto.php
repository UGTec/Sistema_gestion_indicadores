<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteAdjunto extends Model
{
    protected $table = 'reporte_adjunto';

    protected $fillable = [
        'cod_indicador',
        'mes',
        'año',
        'nombre_original',
        'path',
        'cod_usuario'
    ];
}
