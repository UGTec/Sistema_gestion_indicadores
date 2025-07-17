<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            'ver indicadores',
            'crear indicadores',
            'editar indicadores',
            'eliminar indicadores',
            'reportes',
            'administrar usuarios',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $roles = Role::create(['name' => 'Control de Gestión'])
            ->givePermissionTo([
                'ver indicadores',
                'crear indicadores',
                'editar indicadores',
                'eliminar indicadores',
                'reportes',
                'administrar usuarios',
            ]);

        $role = Role::create(['name' => 'Jefatura de División'])
            ->givePermissionTo([
                'ver indicadores',
                'reportes',
            ]);

        $role = Role::create(['name' => 'Informante'])
            ->givePermissionTo([
                'ver indicadores',
                'crear indicadores',
                'editar indicadores',
            ]);
        $role = Role::create(['name' => 'Revisor'])
            ->givePermissionTo([
                'ver indicadores',
                'editar indicadores',
            ]);

        $role = Role::create(['name' => 'Observador'])
            ->givePermissionTo([
                'ver indicadores',
            ]);
    }
}
