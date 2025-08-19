<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                             $cod_indicador
 * @property string|null                     $indicador
 * @property string|null                     $objetivo
 * @property string|null                     $cod_tipo_indicador
 * @property string|null                     $parametro1
 * @property string|null                     $parametro2
 * @property string|null                     $cod_usuario
 * @property float|null                      $meta
 * @property string|null                     $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool                            $cerrado
 * @property \Illuminate\Support\Carbon|null $fecha_cierre
 * @property string                          $estado
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archivo> $archivos
 * @property-read int|null $archivos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndicadorMensual> $indicadoresMensuales
 * @property-read int|null $indicadores_mensuales_count
 * @property-read \App\Models\TipoIndicador|null $tipoIndicador
 * @property-read \App\Models\Usuario|null $usuario
 * @property-read \App\Models\Usuario|null $usuarioAsignado
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodTipoIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereFechaCierre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereObjetivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereParametro1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereParametro2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Indicador extends Model
{
    protected $table      = 'indicador';
    protected $primaryKey = 'cod_indicador';
    public $incrementing  = true;
    protected $keyType    = 'integer';

    protected $fillable = [
        'indicador',
        'objetivo',
        'cod_tipo_indicador',
        'parametro1',
        'parametro2',
        'cod_usuario',
        'meta',
        'cerrado',
        'fecha_cierre',
        'estado'
    ];

    protected $casts = [
        'cerrado'      => 'boolean',
        'fecha_cierre' => 'datetime',
        'meta'         => 'float'
    ];

    public function tipoIndicador(): BelongsTo
    {
        return $this->belongsTo(TipoIndicador::class, 'cod_tipo_indicador');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }

    public function usuarioAsignado(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario_asignado');
    }

    public function indicadoresMensuales(): HasMany
    {
        return $this->hasMany(IndicadorMensual::class, 'cod_indicador');
    }

    public function cerrar(): void
    {
        $this->update([
            'cerrado'      => true,
            'fecha_cierre' => now(),
            'estado'       => 'cerrado'
        ]);
    }

    public function completar(): void
    {
        $this->update([
            'cerrado'      => true,
            'fecha_cierre' => now(),
            'estado'       => 'completado'
        ]);
    }

    public function reabrir(): void
    {
        $this->update([
            'cerrado'      => false,
            'fecha_cierre' => null,
            'estado'       => 'abierto'
        ]);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }
}
