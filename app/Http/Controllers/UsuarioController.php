<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Departamento;
use App\Models\EstadoUsuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:usuarios.index')->only('index');
        // $this->middleware('can:usuarios.create')->only('create', 'store');
        // $this->middleware('can:usuarios.edit')->only('edit', 'update');
        // $this->middleware('can:usuarios.destroy')->only('destroy');
    }

    public function index()
    {
        $usuarios = Usuario::with(['departamento', 'estado'])
            ->orderBy('cod_usuario', 'asc')
            ->get();
        $departamentos = Departamento::orderBy('departamento')->get();
        $estados = EstadoUsuario::all();

        return view('usuarios.index', compact('usuarios', 'departamentos', 'estados'));
    }

    public function show(Usuario $usuario)
    {
        $departamento = $usuario->departamento;
        $estado = $usuario->estado;

        return view('usuarios.show', compact('usuario', 'departamento', 'estado'));
    }

    public function create()
    {
        $departamentos = Departamento::orderBy('departamento')->get();
        $estados       = EstadoUsuario::all();

        return view('usuarios.create', compact('departamentos', 'estados'));
    }

    public function store(StoreUsuarioRequest $request)
    {
        // Generar código de usuario automático
        $lastUser      = Usuario::orderBy('cod_usuario', 'desc')->first();
        $newCodUsuario = $lastUser ? $lastUser->cod_usuario + 1 : 1;

        Usuario::create(array_merge($request->validated(), [
            'cod_usuario' => $newCodUsuario
        ]));

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(Usuario $usuario)
    {
        $departamentos = Departamento::orderBy('departamento')->get();
        $estados       = EstadoUsuario::all();

        return view('usuarios.edit', compact('usuario', 'departamentos', 'estados'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        $usuario->update($request->validated());

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
