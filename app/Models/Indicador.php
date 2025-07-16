<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_indicador
 * @property string $indicador
 * @property string $objetivo
 * @property string|null $cod_tipo_indicador
 * @property string|null $parametro1
 * @property string|null $parametro2
 * @property string|null $cod_usuario
 * @property string|null $meta
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndicadorMensual> $medicionesMensuales
 * @property-read int|null $mediciones_mensuales_count
 * @property-read \App\Models\TipoIndicador|null $tipo
 * @property-read \App\Models\Usuario|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodTipoIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereObjetivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereParametro1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereParametro2($value)
 * @mixin \Eloquent
 */
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
