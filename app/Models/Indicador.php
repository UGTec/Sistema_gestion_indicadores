<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $table      = 'indicador';
    protected $primaryKey = 'cod_indicador';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_indicador',
        'indicador',
        'objetivo',
        'cod_tipo_indicador',
        'parametro1',
        'parametro2',
        'cod_usuario',
        'meta'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoIndicador::class, 'cod_tipo_indicador', 'cod_tipo_indicador');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario', 'cod_usuario');
    }

    public function medicionesMensuales()
    {
        return $this->hasMany(IndicadorMensual::class, 'cod_indicador', 'cod_indicador');
    }
}
