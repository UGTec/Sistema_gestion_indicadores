<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
