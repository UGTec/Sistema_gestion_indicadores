<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 *
 *
 * @property int $cod_usuario
 * @property string|null $usuario
 * @property string|null $nombre
 * @property string|null $primer_apellido
 * @property string|null $segundo_apellido
 * @property string|null $correo_electronico
 * @property string|null $cod_departamento
 * @property string|null $cod_estado_usuario
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Departamento|null $departamento
 * @property-read \App\Models\EstadoUsuario|null $estado
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Indicador> $indicadores
 * @property-read int|null $indicadores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndicadorMensual> $indicadoresMensuales
 * @property-read int|null $indicadores_mensuales_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodEstadoUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCodUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCorreoElectronico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario wherePrimerApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereSegundoApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario whereUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Usuario withoutTrashed()
 * @mixin \Eloquent
 */
class Usuario extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasRoles;

    protected $table = 'usuario';
    protected $primaryKey = 'cod_usuario';

    protected $fillable = [
        'cod_usuario',
        'usuario',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'correo_electronico',
        'password',
        'cod_departamento',
        'cod_estado_usuario',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName(): string
    {
        return 'usuario'; // Cambia 'usuario' por el campo que desees usar para la autenticación
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'cod_departamento', 'cod_departamento');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoUsuario::class, 'cod_estado_usuario', 'cod_estado_usuario');
    }

    public function indicadores(): HasMany
    {
        return $this->hasMany(Indicador::class, 'cod_usuario', 'cod_usuario');
    }

    public function indicadoresMensuales(): HasMany
    {
        return $this->hasMany(IndicadorMensual::class, 'cod_usuario', 'cod_usuario');
    }
}
