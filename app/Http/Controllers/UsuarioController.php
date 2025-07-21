<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Departamento;
use App\Models\EstadoUsuario;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usuarios.ver')->only('index', 'show');
        $this->middleware('can:usuarios.crear')->only('create', 'store');
        $this->middleware('can:usuarios.editar')->only('edit', 'update');
        $this->middleware('can:usuarios.eliminar')->only('destroy');
    }

    public function index()
    {
        $usuarios = Usuario::with(['departamento', 'estado'])
            ->orderBy('cod_usuario', 'asc')
            ->with('roles')
            ->get();
        $departamentos = Departamento::orderBy('departamento')->get();
        $estados       = EstadoUsuario::all();

        return view('usuarios.index', compact('usuarios', 'departamentos', 'estados'));
    }

    public function show(Usuario $usuario)
    {
        $departamento = $usuario->departamento;
        $estado       = $usuario->estado;

        return view('usuarios.show', compact('usuario', 'departamento', 'estado'));
    }

    public function create()
    {
        $departamentos = Departamento::orderBy('departamento')->get();
        $estados       = EstadoUsuario::all();
        $roles         = Role::all();

        return view('usuarios.create', compact('departamentos', 'estados', 'roles'));
    }

    public function store(StoreUsuarioRequest $request)
    {
        $usuario = Usuario::create(array_merge($request->validated(), [
            'cod_usuario' => Usuario::max('cod_usuario') + 1, // Generar código de usuario automático
        ]));

        // Asignar el rol al usuario
        if ($request->has('rol')) {
            $usuario->syncRoles($request->rol);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(Usuario $usuario)
    {
        $departamentos = Departamento::orderBy('departamento')->get();
        $estados       = EstadoUsuario::all();
        $roles         = Role::all();

        return view('usuarios.edit', compact('usuario', 'departamentos', 'estados', 'roles'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        $data = $request->validated();
        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        // Asignar el rol al usuario
        $usuario->syncRoles($data['rol']);

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
