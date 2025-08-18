<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowLog extends Model
{
    protected $table = 'workflow_log';

    protected $fillable = [
        'cod_indicador',
        'mes',
        'año',
        'accion',
        'de_estado',
        'a_estado',
        'cod_usuario',
        'mensaje'
    ];
}
