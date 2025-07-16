<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;

/**
 * 
 *
 * @property string|null $usuario
 * @property string|null $nombre
 * @property string|null $primer_apellido
 * @property string|null $segundo_apellido
 * @property string|null $correo_electronico
 * @property string|null $cod_perfil
 * @property string|null $cod_departamento
 * @property string $cod_usuario
 * @property string|null $cod_estado_usuario
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $email_verified_at
 * @property-read \App\Models\Departamento|null $departamento
 * @property-read \App\Models\EstadoUsuario|null $estado
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Indicador> $indicadores
 * @property-read int|null $indicadores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndicadorMensual> $indicadoresMensuales
 * @property-read int|null $indicadores_mensuales_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Perfil|null $perfil
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodEstadoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodPerfil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCorreoElectronico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario wherePrimerApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereSegundoApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereUsuario($value)
 * @mixin \Eloquent
 */
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

    // public function getRouteKeyName()
    // {
    //     return 'cod_usuario';
    // }

    public function getAuthIdentifierName()
    {
        return 'usuario';
    }

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
