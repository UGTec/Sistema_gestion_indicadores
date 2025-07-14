<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIndicador extends Model
{
    protected $table      = 'tipo_indicador';
    protected $primaryKey = 'cod_tipo_indicador';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_tipo_indicador',
        'tipo_indicador',
        'descripcion'
    ];

    public function indicadores()
    {
        return $this->hasMany(Indicador::class, 'cod_tipo_indicador', 'cod_tipo_indicador');
    }
}
