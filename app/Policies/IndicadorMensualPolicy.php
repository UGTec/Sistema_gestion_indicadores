<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Indicador;
use App\Models\IndicadorMensual;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndicadorMensualPolicy
{
    use HandlesAuthorization;

    public function create(Usuario $user)
    {
        // Solo usuarios asignados al indicador pueden crear registros mensuales
        return $user->hasPermissionTo('indicadores_mensuales.crear') ||
            $user->hasRole('Control de Gestión');
    }

    public function update(Usuario $user, IndicadorMensual $mensual)
    {
        // Solo el creador o Control de Gestión puede editar
        return $user->cod_usuario == $mensual->cod_usuario ||
            $user->hasRole('Control de Gestión');
    }

    public function revisar(Usuario $user, IndicadorMensual $mensual)
    {
        // Solo Control de Gestión puede revisar
        return $user->cod_usuario == $mensual->cod_usuario ||
            $user->hasRole('Control de Gestión');
    }

    public function delete(Usuario $user, IndicadorMensual $mensual)
    {
        // Solo Control de Gestión puede eliminar
        return $user->hasRole('Control de Gestión');
    }
}
