<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $cod_estado_usuario
 * @property string|null $estado_usuario
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Usuario> $usuarios
 * @property-read int|null $usuarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereCodEstadoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereEstadoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario withoutTrashed()
 * @mixin \Eloquent
 */
class EstadoUsuario extends Model
{
    use SoftDeletes;

    protected $table      = 'estado_usuario';
    protected $primaryKey = 'cod_estado_usuario';
    protected $keyType    = 'decimal';
    public $incrementing  = false;

    protected $fillable = [
        'cod_estado_usuario',
        'estado_usuario',
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'cod_estado_usuario', 'cod_estado_usuario');
    }
}
