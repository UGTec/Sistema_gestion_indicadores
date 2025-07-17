<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstadoUsuario;

class EstadoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = EstadoUsuario::all();
        return view('estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cod_estado_usuario' => 'required|numeric|unique:estado_usuario,cod_estado_usuario',
            'estado_usuario' => 'required|string|max:20|unique:estado_usuario,estado_usuario'
        ]);

        EstadoUsuario::create($request->all());

        return redirect()->route('estados.index')
            ->with('success', 'Estado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EstadoUsuario $estado)
    {
        return view('estados.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstadoUsuario $estado)
    {
        return view('estados.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstadoUsuario $estado)
    {
        $request->validate([
            'estado_usuario' => 'required|string|max:20|unique:estado_usuario,estado_usuario,' . $estado->cod_estado_usuario . ',cod_estado_usuario'
        ]);

        $estado->update($request->all());

        return redirect()->route('estados.index')
            ->with('success', 'Estado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoUsuario $estado)
    {
        // Verificar si hay usuarios asociados
        if ($estado->usuarios()->count() > 0) {
            return redirect()->route('estados.index')
                ->with('error', 'No se puede eliminar el estado porque tiene usuarios asociados.');
        }

        $estado->delete();

        return redirect()->route('estados.index')
            ->with('success', 'Estado eliminado exitosamente.');
    }
}
