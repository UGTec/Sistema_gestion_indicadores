<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicional extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'condicional';

    // Indica que la clave primaria no es autoincremental
    public $incrementing = false;

    // Define la clave primaria
    protected $primaryKey = 'cod_condicional';

    // Define el tipo de la clave primaria (numeric/int)
    protected $keyType = 'integer';

    // Las columnas que se pueden asignar masivamente
    protected $fillable = [
        'cod_condicional',
        'condicional',
    ];
}
