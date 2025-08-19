<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\IndicadorMensual;

class ReportePolicy
{
    public function informar(Usuario $user, IndicadorMensual $rep): bool
    {
        return $user->hasRole('informante');
    }
    public function revisar(Usuario $user, IndicadorMensual $rep): bool
    {
        return $user->hasRole('revisor');
    }
    public function controlar(Usuario $user, IndicadorMensual $rep): bool
    {
        return $user->hasRole('control_gestion');
    }
    public function jefatura(Usuario $user, IndicadorMensual $rep): bool
    {
        return $user->hasRole('jefatura_division');
    }
    public function ver(Usuario $user, IndicadorMensual $rep): bool
    {
        return $user->hasAnyRole([
            'informante',
            'revisor',
            'control_gestion',
            'jefatura_division',
            'auditor'
        ]);
    }
}
