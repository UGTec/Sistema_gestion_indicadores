<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $cod_tipo_indicador
 * @property string|null $tipo_indicador
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Indicador> $indicadores
 * @property-read int|null $indicadores_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereCodTipoIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereTipoIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador withoutTrashed()
 * @mixin \Eloquent
 */
class TipoIndicador extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_indicador';
    protected $primaryKey = 'cod_tipo_indicador';
    protected $keyType = 'decimal';
    public $incrementing = false;

    protected $fillable = [
        'cod_tipo_indicador',
        'tipo_indicador',
        'descripcion',
    ];

    public function indicadores(): HasMany
    {
        return $this->hasMany(Indicador::class, 'cod_tipo_indicador', 'cod_tipo_indicador');
    }
}
