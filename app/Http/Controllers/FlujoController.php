<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use App\Models\IndicadorMensual;
use App\Services\FlujoReportes;
use Illuminate\Http\Request;

class FlujoController extends Controller
{
    public function enviarARevisor(Request $req, Indicador $indicador, int $año, int $mes)
    {
        $rep = $this->getReporte($indicador, $año, $mes);
        $this->authorize('informar', $rep);
        FlujoReportes::transicionar($rep, 'informante', 'enviar_a_revisor', $req->input('mensaje'));
        return back()->with('success', 'Enviado a Revisor');
    }

    public function revisorAccion(Request $req, Indicador $indicador, int $año, int $mes)
    {
        $rep = $this->getReporte($indicador, $año, $mes);
        $this->authorize('revisar', $rep);
        $accion = $req->input('accion'); // aprobar | devolver
        FlujoReportes::transicionar($rep, 'revisor', $accion, $req->input('mensaje'));
        return back()->with('success', 'Acción del Revisor ejecutada');
    }

    public function controlAccion(Request $req, Indicador $indicador, int $año, int $mes)
    {
        $rep = $this->getReporte($indicador, $año, $mes);
        $this->authorize('controlar', $rep);
        $accion = $req->input('accion'); // aprobar | devolver
        FlujoReportes::transicionar($rep, 'control_gestion', $accion, $req->input('mensaje'));
        return back()->with('success', 'Acción de Control ejecutada');
    }

    public function jefaturaAccion(Request $req, Indicador $indicador, int $año, int $mes)
    {
        $rep = $this->getReporte($indicador, $año, $mes);
        $this->authorize('jefatura', $rep);
        $accion = $req->input('accion'); // aprobar | devolver
        FlujoReportes::transicionar($rep, 'jefatura_division', $accion, $req->input('mensaje'));
        return back()->with('success', 'Acción de Jefatura ejecutada');
    }

    private function getReporte(Indicador $indicador, int $año, int $mes): IndicadorMensual
    {
        return IndicadorMensual::where('cod_indicador', $indicador->cod_indicador)
            ->where('año', $año)->where('mes', $mes)->firstOrFail();
    }
}
