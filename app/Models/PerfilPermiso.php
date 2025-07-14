<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PerfilPermiso extends Pivot
{
    protected $table      = 'perfil_permiso';
    protected $primaryKey = ['cod_perfil', 'cod_permiso'];
    public $incrementing  = false;
    public $timestamps    = false;

    protected $fillable = [
        'cod_perfil',
        'cod_permiso'
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'cod_perfil', 'cod_perfil');
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'cod_permiso', 'cod_permiso');
    }
}
