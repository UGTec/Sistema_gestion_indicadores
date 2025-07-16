<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_tipo_indicador
 * @property string $tipo_indicador
 * @property string $descripcion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Indicador> $indicadores
 * @property-read int|null $indicadores_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereCodTipoIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoIndicador whereTipoIndicador($value)
 * @mixin \Eloquent
 */
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
