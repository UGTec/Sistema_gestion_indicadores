<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Indicador;
use App\Models\TipoIndicador;
use App\Http\Requests\IndicadorStoreRequest;
use App\Http\Requests\IndicadorUpdateRequest;

class IndicadorController extends Controller
{
    public function index()
    {
        $indicadores = Indicador::with('creador')->get();
        return view('indicadores.index', compact('indicadores'));
    }

    public function create()
    {
        $usuarios = Usuario::get();
        $tipos = TipoIndicador::all();
        return view('indicadores.create', compact('tipos', 'usuarios'));
    }

    public function store(IndicadorStoreRequest $request)
    {
        $nextId = (Indicador::max('cod_indicador') ?? 0) + 1;
        $ind = Indicador::create($request->validated() + [
            'cod_indicador' => $nextId
        ]);

        return redirect()
            ->route('indicadores.show', $ind->cod_indicador)
            ->with('success', 'Indicador creado');
    }

    public function show(Indicador $indicador)
    {
        $indicador->load('reportes');

        return view('indicadores.show', compact('indicador'));
    }

    public function edit(Indicador $indicador)
    {
        $tipos = TipoIndicador::all();
        return view('indicadores.edit', compact('indicador', 'tipos'));
    }

    public function update(IndicadorUpdateRequest $request, Indicador $indicador)
    {
        $indicador->update($request->validated());
        return back()->with('success', 'Indicador actualizado');
    }

    public function destroy(Indicador $indicador)
    {
        $indicador->delete();
        return redirect()->route('indicadores.index')->with('success', 'Indicador eliminado');
    }
}
