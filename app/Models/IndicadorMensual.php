<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $cod_indicador
 * @property string|null $numerador
 * @property string|null $denominador
 * @property string $mes
 * @property string $año
 * @property string|null $resultado
 * @property string|null $cod_usuario
 * @property string|null $fecha_actualizacion
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Indicador $indicador
 * @property-read \App\Models\Usuario|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereAño($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereDenominador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereFechaActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereNumerador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicadorMensual withoutTrashed()
 * @mixin \Eloquent
 */
class IndicadorMensual extends Model
{
    protected $table = 'indicador_mensual';
    //protected $primaryKey = ['cod_indicador', 'mes', 'año'];
    protected $primaryKey = null; // PK compuesta
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cod_indicador',
        'mes',
        'año',
        'numerador',
        'denominador',
        'resultado',
        'cod_usuario',
        'fecha_actualizacion',
        'estado',
        'observaciones',
        'enviado_revisor_at',
        'enviado_control_at',
        'enviado_jefatura_at',
        'aprobado_at'
    ];

    protected $casts = [
        'fecha_actualizacion' => 'date',
        'enviado_revisor_at'  => 'datetime',
        'enviado_control_at'  => 'datetime',
        'enviado_jefatura_at' => 'datetime',
        'aprobado_at'         => 'datetime',
    ];

    // public function indicador()
    // {
    //     return $this->belongsTo(Indicador::class, 'cod_indicador', 'cod_indicador');
    // }

    // public function usuario()
    // {
    //     return $this->belongsTo(Usuario::class, 'cod_usuario', 'cod_usuario');
    // }
    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'cod_indicador', 'cod_indicador');
    }
    public function autor()
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario', 'cod_usuario');
    }
    public function adjuntos()
    {
        return $this->hasMany(ReporteAdjunto::class, 'cod_indicador', 'cod_indicador')
            ->where('mes', $this->mes)->where('año', $this->año);
    }
    public function logs()
    {
        return $this->hasMany(WorkflowLog::class, 'cod_indicador', 'cod_indicador')
            ->where('mes', $this->mes)->where('año', $this->año);
    }
}
