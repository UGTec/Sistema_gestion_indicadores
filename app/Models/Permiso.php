<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_permiso
 * @property string $permiso
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Perfil> $perfiles
 * @property-read int|null $perfiles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso whereCodPermiso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso wherePermiso($value)
 * @mixin \Eloquent
 */
class Permiso extends Model
{
    protected $table      = 'permiso';
    protected $primaryKey = 'cod_permiso';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_permiso',
        'permiso'
    ];

    public function perfiles()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_permiso', 'cod_permiso', 'cod_perfil');
    }
}
