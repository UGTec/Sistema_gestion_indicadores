<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicadorMensual extends Model
{
    protected $table      = 'indicador_mensual';
    protected $primaryKey = ['cod_indicador', 'mes', 'año'];
    public $incrementing  = false;
    public $timestamps    = false;

    protected $fillable = [
        'cod_indicador',
        'numerador',
        'denominador',
        'mes',
        'año',
        'resultado',
        'cod_usuario',
        'fecha_actualizacion'
    ];

    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'cod_indicador', 'cod_indicador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario', 'cod_usuario');
    }
}
