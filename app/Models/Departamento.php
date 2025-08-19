<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $cod_departamento
 * @property string|null $departamento
 * @property string|null $cod_division
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Division|null $division
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Usuario> $usuarios
 * @property-read int|null $usuarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereCodDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereCodDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento withoutTrashed()
 * @mixin \Eloquent
 */
class Departamento extends Model
{
    use SoftDeletes;

    protected $table      = 'departamento';
    protected $primaryKey = 'cod_departamento';
    protected $keyType    = 'decimal';
    public $incrementing  = false;

    protected $fillable = [
        'cod_departamento',
        'departamento',
        'cod_division',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'cod_division', 'cod_division');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'cod_departamento', 'cod_departamento');
    }
}
