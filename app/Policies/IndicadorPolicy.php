<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Indicador;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndicadorPolicy
{
    use HandlesAuthorization;

    public function viewAny(Usuario $user)
    {
        return $user->hasPermissionTo('indicadores.ver');
    }

    public function view(Usuario $user, Indicador $indicador)
    {
        // Control de Gestión puede ver todos
        if ($user->hasRole('Control de Gestión')) {
            return true;
        }

        // Otros usuarios solo pueden ver los asignados a ellos
        return $user->hasPermissionTo('indicadores.ver') &&
            $indicador->cod_usuario_asignado == $user->cod_usuario;
    }

    public function create(Usuario $user)
    {
        return $user->hasPermissionTo('indicadores.crear');
    }

    public function update(Usuario $user, Indicador $indicador)
    {
        // Solo se puede editar si está abierto
        if ($indicador->cerrado) {
            return false;
        }

        // Control de Gestión puede editar todos
        if ($user->hasRole('Control de Gestión')) {
            return true;
        }

        // Usuario asignado puede editar
        return $user->hasPermissionTo('indicadores.editar') &&
            $indicador->cod_usuario_asignado == $user->cod_usuario;
    }

    public function delete(Usuario $user, Indicador $indicador)
    {
        return $user->hasRole('Control de Gestión');
    }

    public function cerrar(Usuario $user, Indicador $indicador)
    {
        return !$indicador->cerrado &&
            $user->cod_usuario == $indicador->cod_usuario_asignado;
    }

    public function completar(Usuario $user, Indicador $indicador)
    {
        return !$indicador->cerrado &&
            $user->cod_usuario == $indicador->cod_usuario_asignado;
    }

    public function reabrir(Usuario $user, Indicador $indicador)
    {
        return $indicador->cerrado &&
            $user->hasRole('Control de Gestión');
    }
}
