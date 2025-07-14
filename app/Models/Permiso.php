<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
