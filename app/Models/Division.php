<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table      = 'division';
    protected $primaryKey = 'cod_division';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_division',
        'division'
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'cod_division', 'cod_division');
    }
}
