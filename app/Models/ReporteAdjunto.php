<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $cod_indicador
 * @property int $mes
 * @property int $año
 * @property string $nombre_original
 * @property string $path
 * @property int $cod_usuario
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereAño($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereCodIndicador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereNombreOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReporteAdjunto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReporteAdjunto extends Model
{
    protected $table = 'reporte_adjunto';

    protected $fillable = [
        'cod_indicador',
        'mes',
        'año',
        'nombre_original',
        'path',
        'cod_usuario'
    ];
}
