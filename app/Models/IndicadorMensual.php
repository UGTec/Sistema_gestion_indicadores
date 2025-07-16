<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_indicador
 * @property string|null $numerador
 * @property string|null $denominador
 * @property string $mes
 * @property string $año
 * @property string|null $resultado
 * @property string|null $cod_usuario
 * @property string|null $fecha_actualizacion
 * @property-read \App\Models\Indicador $indicador
 * @property-read \App\Models\Usuario|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereAño($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereDenominador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereFechaActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereNumerador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereResultado($value)
 * @mixin \Eloquent
 */
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
