<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
