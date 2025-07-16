<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_departamento
 * @property string $departamento
 * @property string $cod_division
 * @property-read \App\Models\Division $division
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Usuario> $usuarios
 * @property-read int|null $usuarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereCodDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereCodDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereDepartamento($value)
 * @mixin \Eloquent
 */
class Departamento extends Model
{
    protected $table      = 'departamento';
    protected $primaryKey = 'cod_departamento';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_departamento',
        'departamento',
        'cod_division'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'cod_division', 'cod_division');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'cod_departamento', 'cod_departamento');
    }
}
