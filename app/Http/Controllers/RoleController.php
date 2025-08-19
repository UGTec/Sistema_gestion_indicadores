<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.ver')->only('index');
        $this->middleware('can:roles.crear')->only('create', 'store');
        $this->middleware('can:roles.editar')->only('edit', 'update');
        $this->middleware('can:roles.eliminar')->only('destroy');
    }

    public function index()
    {
        $roles = Role::withCount('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('.', $item->name)[0]; // Agrupa por módulo
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permisos,id'
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            // Obtener los modelos de permisos completos basados en los IDs
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            // Sincronizar usando los modelos de permisos
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Perfil creado exitosamente.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('.', $item->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'          => 'required|string|unique:roles,name,' . $role->id,
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permisos,id'
        ]);

        if ($request->has('permissions')) {
            // Obtener los modelos de permisos completos basados en los IDs
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            // Sincronizar usando los modelos de permisos
            $role->syncPermissions($permissions);
        } else {
            // Si no se enviaron permisos, eliminar todos
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')
            ->with('success', value: 'Perfil actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        // No permitir eliminar roles del sistema
        if (in_array($role->name, ['Control de Gestión', 'Jefatura de División', 'Informante', 'Revisor', 'Observador'])) {
            return redirect()->route('roles.index')
                ->with('error', 'No se puede eliminar este rol del sistema.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado exitosamente.');
    }
}
