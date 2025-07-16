<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_estado_usuario
 * @property string $estado_usuario
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Usuario> $usuarios
 * @property-read int|null $usuarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereCodEstadoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereEstadoUsuario($value)
 * @mixin \Eloquent
 */
class EstadoUsuario extends Model
{
    protected $table      = 'estado_usuario';
    protected $primaryKey = 'cod_estado_usuario';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_estado_usuario',
        'estado_usuario'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'cod_estado_usuario', 'cod_estado_usuario');
    }
}
