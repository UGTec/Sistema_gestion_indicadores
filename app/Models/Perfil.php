<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_perfil
 * @property string $perfil
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permiso> $permisos
 * @property-read int|null $permisos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Usuario> $usuarios
 * @property-read int|null $usuarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Perfil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Perfil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Perfil query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Perfil whereCodPerfil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Perfil wherePerfil($value)
 * @mixin \Eloquent
 */
class Perfil extends Model
{
    protected $table      = 'perfil';
    protected $primaryKey = 'cod_perfil';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_perfil',
        'perfil'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'cod_perfil', 'cod_perfil');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'perfil_permiso', 'cod_perfil', 'cod_permiso');
    }
}
