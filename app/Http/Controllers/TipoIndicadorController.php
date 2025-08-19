<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoIndicador;

class TipoIndicadorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:tipos_indicador.ver')->only('index');
        // $this->middleware('can:tipos_indicador.crear')->only('create', 'store');
        // $this->middleware('can:tipos_indicador.editar')->only('edit', 'update');
        // $this->middleware('can:tipos_indicador.eliminar')->only('destroy');
    }

    public function index()
    {
        $tipos = TipoIndicador::orderBy('cod_tipo_indicador')->get();

        return view('tipos_indicador.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos_indicador.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_tipo_indicador' => 'required|numeric|unique:tipo_indicador,cod_tipo_indicador',
            'tipo_indicador'     => 'required|string|max:10',
            'descripcion'        => 'required|string|max:75'
        ]);

        TipoIndicador::create($request->all());

        return redirect()->route('tipos_indicador.index')
            ->with('success', 'Tipo de indicador creado exitosamente.');
    }

    public function show(TipoIndicador $tipo)
    {
        return view('tipos_indicador.show', compact('tipo'));
    }

    public function edit(TipoIndicador $tipo)
    {
        return view('tipos_indicador.edit', compact('tipo'));
    }

    public function update(Request $request, TipoIndicador $tipo)
    {
        $request->validate([
            'tipo_indicador' => 'required|string|max:10',
            'descripcion'    => 'required|string|max:75'
        ]);

        $tipo->update($request->all());

        return redirect()->route('tipos_indicador.index')
            ->with('success', 'Tipo de indicador actualizado exitosamente.');
    }

    public function destroy(TipoIndicador $tipo)
    {
        if ($tipo->indicadores()->count() > 0) {
            return redirect()->route('tipos_indicador.index')
                ->with('error', 'No se puede eliminar el tipo porque tiene indicadores asociados.');
        }

        $tipo->delete();

        return redirect()->route('tipos_indicador.index')
            ->with('success', 'Tipo de indicador eliminado exitosamente.');
    }
}
