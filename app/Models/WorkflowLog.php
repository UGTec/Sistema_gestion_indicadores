<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $cod_indicador
 * @property int $mes
 * @property int $año
 * @property string $accion
 * @property string|null $de_estado
 * @property string|null $a_estado
 * @property int $cod_usuario
 * @property string|null $mensaje
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereAEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereAccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereAño($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereDeEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereMensaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
