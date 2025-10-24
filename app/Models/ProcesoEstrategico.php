<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoEstrategico extends Model
{
    protected $table = 'proceso_estrategico';

    protected $fillable = [
        'nombre_proceso',
    ];

    /**
     * Obtiene todos los indicadores mensuales asociados a este proceso.
     */
    public function indicadoresMensuales()
    {
        // Se especifica la clave foránea 'cod_proceso_estrategico'
        // porque no sigue la convención estándar
        return $this->hasMany(IndicadorMensual::class, 'cod_proceso_estrategico');
    }
}
