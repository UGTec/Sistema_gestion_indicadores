<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicadorProyeccionMensual extends Model
{
    protected $table = 'indicador_proyeccion_mensual';

    protected $fillable = [
        'cod_indicador',
        'anio',
        'mes',
        'valor',
        'cod_usuario',
    ];

    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'cod_indicador', 'cod_indicador');
    }
}
