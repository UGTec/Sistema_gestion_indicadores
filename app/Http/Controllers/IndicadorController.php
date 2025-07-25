<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicador;
use App\Models\TipoIndicador;
use App\Models\Usuario;

class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indicadores = Indicador::with(['tipoIndicador', 'usuario'])
            ->orderBy('cod_indicador')
            ->get();

        return view('indicadores.index', compact('indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = TipoIndicador::all();
        $usuarios = Usuario::where('cod_estado_usuario', 1)->get();

        return view('indicadores.create', compact('tipos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cod_indicador'      => 'required|numeric|unique:indicador,cod_indicador',
            'indicador'          => 'required|string|max:4098',
            'objetivo'           => 'required|string|max:4098',
            'cod_tipo_indicador' => 'required|exists:tipo_indicador,cod_tipo_indicador',
            'cod_usuario'        => 'required|exists:usuario,cod_usuario',
            'meta'               => 'nullable|numeric'
        ]);

        Indicador::create($request->all());

        return redirect()->route('indicadores.index')
            ->with('success', 'Indicador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Indicador $indicador)
    {
        $registros = $indicador->registrosMensuales()
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        return view('indicadores.show', compact('indicador', 'registros'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Indicador $indicador)
    {
        $tipos = TipoIndicador::all();
        $usuarios = Usuario::where('cod_estado_usuario', 1)->get();

        return view('indicadores.edit', compact('indicador', 'tipos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Indicador $indicador)
    {
        $request->validate([
            'indicador'          => 'required|string|max:4098',
            'objetivo'           => 'required|string|max:4098',
            'cod_tipo_indicador' => 'required|exists:tipo_indicador,cod_tipo_indicador',
            'cod_usuario'        => 'required|exists:usuario,cod_usuario',
            'meta'               => 'nullable|numeric'
        ]);

        $indicador->update($request->all());

        return redirect()->route('indicadores.index')
            ->with('success', 'Indicador actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Indicador $indicador)
    {
        $indicador->delete();

        return redirect()->route('indicadores.index')
            ->with('success', 'Indicador eliminado exitosamente.');
    }
}
