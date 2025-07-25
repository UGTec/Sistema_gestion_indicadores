<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use App\Models\IndicadorMensual;
use App\Models\Usuario;
use Illuminate\Http\Request;

class IndicadorMensualController extends Controller
{
    public function create(Indicador $indicador)
    {
        $usuarios = Usuario::where('cod_estado_usuario', 1)->get();
        $meses = [
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        return view('indicadores.registros.create', compact('indicador', 'usuarios', 'meses'));
    }

    public function store(Request $request, Indicador $indicador)
    {
        $request->validate([
            'numerador'   => 'required|numeric',
            'denominador' => 'required|numeric',
            'mes'         => 'required|numeric|between:1,12',
            'año'         => 'required|numeric|digits:4',
            'cod_usuario' => 'required|exists:usuario,cod_usuario'
        ]);

        $data = $request->all();
        $data['cod_indicador'] = $indicador->cod_indicador;

        // Calcular resultado si no se proporciona
        if (!isset($data['resultado'])) {
            $data['resultado'] = $request->denominador != 0
            ? round(($request->numerador / $request->denominador) * 100, 2)
            : 0;
        }

        IndicadorMensual::create($data);

        return redirect()->route('indicadores.show', $indicador->cod_indicador)
            ->with('success', 'Registro mensual agregado exitosamente.');
    }

    public function edit(Indicador $indicador, IndicadorMensual $registro)
    {
        $usuarios = Usuario::where('cod_estado_usuario', 1)->get();
        $meses = [
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        return view('indicadores.registros.edit', compact('indicador', 'registro', 'usuarios', 'meses'));
    }

    public function update(Request $request, Indicador $indicador, IndicadorMensual $registro)
    {
        $request->validate([
            'numerador'   => 'required|numeric',
            'denominador' => 'required|numeric',
            'mes'         => 'required|numeric|between:1,12',
            'año'         => 'required|numeric|digits:4',
            'cod_usuario' => 'required|exists:usuario,cod_usuario'
        ]);

        $data = $request->all();

        // Calcular resultado si no se proporciona
        if (!isset($data['resultado'])) {
            $data['resultado'] = $request->denominador != 0
                ? round(($request->numerador / $request->denominador) * 100, 2)
                : 0;
        }

        $registro->update($data);

        return redirect()->route('indicadores.show', $indicador->cod_indicador)
            ->with('success', 'Registro mensual actualizado exitosamente.');
    }

    public function destroy(Indicador $indicador, IndicadorMensual $registro)
    {
        $registro->delete();

        return redirect()->route('indicadores.show', $indicador->cod_indicador)
            ->with('success', 'Registro mensual eliminado exitosamente.');
    }
}
