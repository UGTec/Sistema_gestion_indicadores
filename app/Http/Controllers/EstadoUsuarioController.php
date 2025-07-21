<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstadoUsuario;

class EstadoUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:estados.ver')->only(['index']);
        $this->middleware('can:estados.crear')->only(['create', 'store']);
        $this->middleware('can:estados.editar')->only(['edit', 'update']);
        $this->middleware('can:estados.eliminar')->only(['destroy']);
    }
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
        $request->validate(
            [
            //'cod_estado_usuario' => 'required|numeric|unique:estado_usuario,cod_estado_usuario',
            'estado_usuario' => 'required|string|max:20|unique:estado_usuario,estado_usuario'
        ],
            [
                //'cod_estado_usuario.required' => 'El código del estado es obligatorio.',
                //'cod_estado_usuario.numeric' => 'El código del estado debe ser un número.',
                //'cod_estado_usuario.unique' => 'El código del estado ya existe.',
                'estado_usuario.required' => 'El nombre del estado es obligatorio.',
                'estado_usuario.string'   => 'El nombre del estado debe ser una cadena de texto.',
                'estado_usuario.max'      => 'El nombre del estado no puede exceder los 20 caracteres.',
                'estado_usuario.unique'   => 'El nombre del estado ya existe.'
            ]
        );

        EstadoUsuario::create(array_merge($request->all(), [
            // Generar código de estado automático
            'cod_estado_usuario' => EstadoUsuario::max('cod_estado_usuario') + 1,
        ]));

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
