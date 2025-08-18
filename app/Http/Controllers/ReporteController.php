<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicador;
use App\Models\IndicadorMensual;
use App\Models\ReporteAdjunto;
use App\Http\Requests\ReporteStoreRequest;
use Illuminate\Support\Facades\Storage;

class ReporteController extends Controller
{
    public function create(Indicador $indicador, int $año, int $mes)
    {
        $reporte = IndicadorMensual::firstOrNew(
            [
                'cod_indicador' => $indicador->cod_indicador,
                'año' => $año,
                'mes' => $mes,
            ],
            [
                'estado' => 'por_informar',
                'cod_usuario' => 1
            ]
        );
        return view('reportes.create', compact('indicador', 'reporte'));
    }

    public function store(ReporteStoreRequest $request, Indicador $indicador, int $año, int $mes)
    {
        $data = $request->validated();
        $reporte = IndicadorMensual::updateOrCreate(
            ['cod_indicador' => $indicador->cod_indicador, 'año' => $año, 'mes' => $mes],
            [
                'numerador' => $data['numerador'],
                'denominador' => $data['denominador'],
                'resultado' => ($data['denominador'] ?? 0) ? ($data['numerador'] / $data['denominador'] * 100) : null,
                'cod_usuario' => auth()->id(),
                'fecha_actualizacion' => now(),
                'observaciones' => $data['observaciones'] ?? null,
                'estado' => 'por_informar',
            ]
        );

        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $file) {
                $path = $file->store('adjuntos', 'public');
                ReporteAdjunto::create([
                    'cod_indicador' => $indicador->cod_indicador,
                    'año' => $año,
                    'mes' => $mes,
                    'nombre_original' => $file->getClientOriginalName(),
                    'path' => $path,
                    'cod_usuario' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('reportes.show', [$indicador->cod_indicador, $año, $mes])->with('success', 'Reporte guardado');
    }

    public function show(Indicador $indicador, int $año, int $mes)
    {
        $reporte = IndicadorMensual::where(compact('año', 'mes'))
            ->where('cod_indicador', $indicador->cod_indicador)
            ->firstOrFail();
        $reporte->load('adjuntos', 'logs');
        return view('reportes.show', compact('indicador', 'reporte'));
    }

    public function descargarAdjunto(ReporteAdjunto $adjunto)
    {
        return response()->download(storage_path('app/public/' . $adjunto->path), $adjunto->nombre_original);
    }
}
