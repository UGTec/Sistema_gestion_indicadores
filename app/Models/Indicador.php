<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $cod_indicador
 * @property string|null $indicador
 * @property string|null $objetivo
 * @property string|null $cod_tipo_indicador
 * @property string|null $parametro1
 * @property string|null $parametro2
 * @property string|null $cod_usuario
 * @property string|null $meta
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndicadorMensual> $indicadoresMensuales
 * @property-read int|null $indicadores_mensuales_count
 * @property-read \App\Models\TipoIndicador|null $tipoIndicador
 * @property-read \App\Models\Usuario|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodTipoIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereObjetivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereParametro1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereParametro2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Indicador withoutTrashed()
 * @mixin \Eloquent
 */
class Indicador extends Model
{
    use SoftDeletes;

    protected $table = 'indicador';
    protected $primaryKey = 'cod_indicador';
    protected $keyType = 'decimal';
    public $incrementing = false;

    protected $fillable = [
        'cod_indicador',
        'indicador',
        'objetivo',
        'cod_tipo_indicador',
        'parametro1',
        'parametro2',
        'cod_usuario',
        'meta',
    ];

    public function tipoIndicador(): BelongsTo
    {
        return $this->belongsTo(TipoIndicador::class, 'cod_tipo_indicador', 'cod_tipo_indicador');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario', 'cod_usuario');
    }

    public function indicadoresMensuales(): HasMany
    {
        return $this->hasMany(IndicadorMensual::class, 'cod_indicador', 'cod_indicador');
    }
}
