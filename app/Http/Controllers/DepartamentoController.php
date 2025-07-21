<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:departamentos.ver')->only('index', 'show');
        $this->middleware('can:departamentos.crear')->only('create', 'store');
        $this->middleware('can:departamentos.editar')->only('edit', 'update');
        $this->middleware('can:departamentos.eliminar')->only('destroy');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamento::with('division')->get();
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        return view('departamentos.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            //'cod_departamento' => 'required|numeric|unique:departamento,cod_departamento',
            'departamento' => 'required|string|max:75|unique:departamento,departamento',
            'cod_division' => 'required|numeric|exists:division,cod_division'
        ]);

        // Verificar si el código de departamento ya existe
        if (Departamento::where('cod_departamento', $request->cod_departamento)->exists()) {
            return redirect()->back()
                ->withErrors(['cod_departamento' => 'El código de departamento ya existe.'])
                ->withInput();
        }
        // Crear el departamento
        //Departamento::create($request->all());
        Departamento::create(array_merge($request->all(), [
            // Generar código de departamento automático
            'cod_departamento' => Departamento::max('cod_departamento') + 1,
        ]));

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        return view('departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        $divisions = Division::all();
        return view('departamentos.edit', compact('departamento', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'departamento' => 'required|string|max:75',
            'cod_division' => 'required|numeric|exists:division,cod_division'
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        // Verificar si hay usuarios asociados
        if ($departamento->usuarios()->count() > 0) {
            return redirect()->route('departamentos.index')
                ->with('error', 'No se puede eliminar el departamento porque tiene usuarios asociados.');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento eliminado exitosamente.');
    }
}
