<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                             $cod_indicador
 * @property string|null                     $numerador
 * @property string|null                     $denominador
 * @property string                          $mes
 * @property string                          $año
 * @property float|null                      $resultado
 * @property string|null                     $cod_usuario
 * @property \Illuminate\Support\Carbon|null $fecha_actualizacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string                          $estado
 * @property string|null                     $observaciones
 * @property string|null                     $enviado_revisor_at
 * @property string|null                     $enviado_control_at
 * @property string|null                     $enviado_jefatura_at
 * @property string|null                     $aprobado_at
 * @property int                             $id
 * @property string|null                     $cod_usuario_modificacion
 * @property-read \App\Models\Indicador $indicador
 * @property-read \App\Models\Usuario|null $usuario
 * @property-read \App\Models\Usuario|null $usuarioModificacion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereAprobadoAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereAño($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodUsuarioModificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereDenominador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereEnviadoControlAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereEnviadoJefaturaAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereEnviadoRevisorAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereFechaActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereNumerador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IndicadorMensual extends Model
{
    protected $table = 'indicador_mensual';

    protected $fillable = [
        'cod_indicador',
        'numerador',
        'denominador',
        'mes',
        'año',
        'resultado',
        'cod_usuario',
        'cod_usuario_modificacion',
        'fecha_actualizacion',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_actualizacion' => 'datetime',
        'resultado'           => 'float'
    ];

    public function indicador(): BelongsTo
    {
        return $this->belongsTo(Indicador::class, 'cod_indicador');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }

    public function usuarioModificacion(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario_modificacion');
    }
}
