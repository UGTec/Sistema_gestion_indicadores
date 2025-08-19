<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicador extends Model
{
    protected $table = 'indicador';
    protected $primaryKey = 'cod_indicador';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'indicador',
        'objetivo',
        'cod_tipo_indicador',
        'parametro1',
        'parametro2',
        'cod_usuario',
        'meta',
        'cerrado',
        'fecha_cierre',
        'estado'
    ];

    protected $casts = [
        'cerrado' => 'boolean',
        'fecha_cierre' => 'datetime',
        'meta' => 'float'
    ];

    public function tipoIndicador(): BelongsTo
    {
        return $this->belongsTo(TipoIndicador::class, 'cod_tipo_indicador');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }

    public function usuarioAsignado(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario_asignado');
    }

    public function indicadoresMensuales(): HasMany
    {
        return $this->hasMany(IndicadorMensual::class, 'cod_indicador');
    }

    public function cerrar(): void
    {
        $this->update([
            'cerrado' => true,
            'fecha_cierre' => now(),
            'estado' => 'cerrado'
        ]);
    }

    public function completar(): void
    {
        $this->update([
            'cerrado' => true,
            'fecha_cierre' => now(),
            'estado' => 'completado'
        ]);
    }

    public function reabrir(): void
    {
        $this->update([
            'cerrado' => false,
            'fecha_cierre' => null,
            'estado' => 'abierto'
        ]);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }
}
