<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int                             $id
 * @property int                             $cod_indicador
 * @property int                             $anio
 * @property int                             $mes
 * @property string                          $valor
 * @property int|null                        $cod_usuario
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Indicador $indicador
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorProyeccionMensual whereValor($value)
 * @mixin \Eloquent
 */
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
