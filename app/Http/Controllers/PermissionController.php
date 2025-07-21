<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permisos.ver')->only('index');
        $this->middleware('can:permisos.crear')->only('create', 'store');
        $this->middleware('can:permisos.editar')->only('edit', 'update');
        $this->middleware('can:permisos.eliminar')->only('destroy');
    }

    public function index()
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('.', $item->name)[0];
        });
        return view('permisos.index', compact('permissions'));
    }

    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
            'name' => 'required|string|unique:permisos,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|distinct'
        ],
            [
            'name.required' => 'El nombre del módulo es obligatorio.',
            'name.unique' => 'El nombre del módulo ya existe.',
            'permissions.required' => 'Debe ingresar al menos un permiso.',
            'permissions.array' => 'Los permisos deben ser un arreglo.',
            'permissions.*.required' => 'Cada permiso es obligatorio.',
            'permissions.*.distinct' => 'Los permisos deben ser únicos.'
            ],
            [
            'name' => 'Módulo',
            'permissions' => 'Permisos'
            ]
        );

        try {
            $createdPermissions = [];

            foreach ($validated['permissions'] as $permission) {
                $permissionName = str($validated['name'] . '.' . $permission);
                $createdPermissions[] = Permission::first(['name' => $permissionName]) ?? Permission::create([
                    'name' => $permissionName,
                    'guard_name' => 'web'
                ]);
            }
            return redirect()->route('permisos.index')
                    ->with('success', 'Permisos creados exitosamente: ')
                    ->with('created_permissions', $createdPermissions);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al crear los permisos: ' . $e->getMessage());
        }
    }

    public function edit(Permission $permission)
    {
        return view('permisos.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso actualizado exitosamente.');
    }

    public function destroy(Permission $permission)
    {
        // Verificar si el permiso está asignado a algún rol
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permisos.index')
                ->with('error', 'No se puede eliminar el permiso porque está asignado a roles.');
        }

        $permission->delete();

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso eliminado exitosamente.');
    }
}
