<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use Illuminate\Http\Request;
use App\Models\IndicadorMensual;

class IndicadorMensualController extends Controller
{
    public function create(Indicador $indicador)
    {
        $this->authorize('create', [IndicadorMensual::class, $indicador]);

        return view('indicadores-mensuales.create', compact('indicador'));
    }

    public function store(Request $request, Indicador $indicador)
    {
        $this->authorize('create', [IndicadorMensual::class, $indicador]);

        $data = $request->validate(
            [
                'mes'           => 'required|numeric|between:1,12',
                'año'           => 'required|numeric|min:' . date('Y') . '|max:' . (date('Y') + 1),
                'numerador'     => 'required|numeric',
                'denominador'   => 'required|numeric',
                'observaciones' => 'nullable|string|max:500',
            ],
            [
                'año.min' => 'El año no puede ser menor al año en curso',
            ]
        );

        $data['resultado']           = ($data['numerador'] / $data['denominador']) * 100;
        $data['cod_usuario']         = auth()->user()->cod_usuario;
        $data['fecha_actualizacion'] = now();

        $indicador->indicadoresMensuales()->create($data);

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Registro mensual creado exitosamente');
    }

    public function edit(Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('update', $mensual);

        return view('indicadores-mensuales.edit', compact('indicador', 'mensual'));
    }

    public function update(Request $request, Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('update', $mensual);

        $data = $request->validate([
            'numerador'     => 'required|numeric',
            'denominador'   => 'required|numeric',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $data['resultado']                = ($data['numerador'] / $data['denominador']) * 100;
        $data['cod_usuario_modificacion'] = auth()->user()->cod_usuario;
        $data['fecha_actualizacion']      = now();

        $mensual->update($data);

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Registro mensual actualizado exitosamente');
    }

    public function destroy(Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('delete', $mensual);

        $mensual->delete();

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Registro mensual eliminado exitosamente');
    }
}
