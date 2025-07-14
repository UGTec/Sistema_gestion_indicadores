<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
