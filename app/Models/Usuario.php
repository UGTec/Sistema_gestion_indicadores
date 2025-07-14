<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;

class Usuario extends Authenticable
{
    use Notifiable;

    protected $table      = 'usuario';
    protected $primaryKey = 'cod_usuario';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'usuario',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'correo_electronico',
        'password',
        'cod_perfil',
        'cod_departamento',
        //'cod_usuario',
        'cod_estado_usuario',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relaciones con otros modelos
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'cod_perfil', 'cod_perfil');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'cod_departamento', 'cod_departamento');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoUsuario::class, 'cod_estado_usuario', 'cod_estado_usuario');
    }

    public function indicadores()
    {
        return $this->hasMany(Indicador::class, 'cod_usuario', 'cod_usuario');
    }

    public function indicadoresMensuales()
    {
        return $this->hasMany(IndicadorMensual::class, 'cod_usuario', 'cod_usuario');
    }
}
