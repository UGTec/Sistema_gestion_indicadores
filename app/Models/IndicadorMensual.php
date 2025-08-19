<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicadorMensual extends Model
{
    protected $table = 'indicador_mensual';

    protected $fillable = [
        'cod_indicador',
        'numerador',
        'denominador',
        'mes',
        'año',
        'resultado',
        'cod_usuario',
        'cod_usuario_modificacion',
        'fecha_actualizacion'
    ];

    protected $casts = [
        'fecha_actualizacion' => 'datetime',
        'resultado' => 'float'
    ];

    public function indicador(): BelongsTo
    {
        return $this->belongsTo(Indicador::class, 'cod_indicador');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }

    public function usuarioModificacion(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario_modificacion');
    }
}
