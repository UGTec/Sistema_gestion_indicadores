<?php

namespace App\Services;

use App\Models\IndicadorMensual;
use App\Models\WorkflowLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReporteEstadoCambiado;

class FlujoReportes
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static array $transiciones = [
        // actor => [ estado_actual => [accion => estado_siguiente] ]
        'informante' => [
            'por_informar' => [
                'enviar_a_revisor' => 'en_revision_revisor'
            ],
            'devuelto' => [
                'reenviar_a_revisor' => 'en_revision_revisor'
            ],
        ],
        'revisor' => [
            'en_revision_revisor' => [
                'devolver' => 'devuelto',
                'aprobar'  => 'en_revision_control'
            ],
        ],
        'control_gestion' => [
            'en_revision_control' => [
                'devolver' => 'devuelto',
                'aprobar'  => 'en_revision_jefatura'
            ],
        ],
        'jefatura_division' => [
            'en_revision_jefatura' => [
                'devolver' => 'devuelto',
                'aprobar'  => 'aprobado'
            ],
        ],
    ];

    public static function transicionar(IndicadorMensual $rep, string $rolActor, string $accion, ?string $mensaje = null): IndicadorMensual
    {
        $actual    = $rep->estado;
        $siguiente = self::$transiciones[$rolActor][$actual][$accion] ?? null;

        if (!$siguiente) {
            abort(403, 'Transición no permitida');
        }

        return DB::transaction(function () use ($rep, $actual, $siguiente, $mensaje) {
            $rep->estado = $siguiente;
            $now = now();

            if ($siguiente === 'en_revision_revisor') $rep->enviado_revisor_at = $now;
            if ($siguiente === 'en_revision_control') $rep->enviado_control_at = $now;
            if ($siguiente === 'en_revision_jefatura') $rep->enviado_jefatura_at = $now;
            if ($siguiente === 'aprobado') $rep->aprobado_at = $now;

            $rep->save();

            WorkflowLog::create([
                'cod_indicador' => $rep->cod_indicador,
                'mes'           => $rep->mes,
                'año'           => $rep->año,
                'accion'        => $accion,
                'de_estado'     => $actual,
                'a_estado'      => $siguiente,
                'cod_usuario'   => Auth::id(),
                'mensaje'       => $mensaje,
            ]);

            // Notificaciones (ejemplo simple: a creador del indicador)
            if ($rep->indicador && $rep->indicador->creador) {
                Notification::route('mail', $rep->indicador->creador->correo_electronico)
                    ->notify(new ReporteEstadoCambiado($rep));
            }

            return $rep;
        });
    }
}
