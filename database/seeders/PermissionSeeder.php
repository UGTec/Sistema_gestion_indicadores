<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Usuario;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos para Indicadores
        $indicadorPermissions = [
            'indicadores.ver',
            'indicadores.crear',
            'indicadores.editar',
            'indicadores.eliminar',
            'indicadores.reportes',
        ];

        // Permisos para Usuarios
        $usuarioPermissions = [
            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
        ];

        // Permisos para Departamentos
        $departamentoPermissions = [
            'departamentos.ver',
            'departamentos.crear',
            'departamentos.editar',
            'departamentos.eliminar',
        ];

        // Permisos para Estados de Usuario
        $estadoUsuarioPermissions = [
            'estados.ver',
            'estados.crear',
            'estados.editar',
            'estados.eliminar',
        ];

        // Permisos para Roles y Permisos
        $rolePermissions = [
            'roles.ver',
            'roles.crear',
            'roles.editar',
            'roles.eliminar',
        ];

        $permissionPermissions = [
            'permisos.ver',
            'permisos.crear',
            'permisos.editar',
            'permisos.eliminar',
        ];

        // Combinar todos los permisos
        $allPermissions = array_merge(
            $indicadorPermissions,
            $usuarioPermissions,
            $departamentoPermissions,
            $estadoUsuarioPermissions,
            $rolePermissions,
            $permissionPermissions
        );

        // Crear permisos en la base de datos
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear roles y asignar permisos según los perfiles del sistema

        // 1. Control de Gestión (todos los permisos)
        $roleControlGestion = Role::create(['name' => 'Control de Gestión', 'guard_name' => 'web']);
        $roleControlGestion->givePermissionTo($allPermissions);

        // 2. Jefatura de División
        $roleJefatura = Role::create(['name' => 'Jefatura de División', 'guard_name' => 'web']);
        $roleJefatura->givePermissionTo([
            'indicadores.ver',
            'indicadores.reportes',
            'departamentos.ver',
            'usuarios.ver'
        ]);

        // 3. Informante
        $roleInformante = Role::create(['name' => 'Informante', 'guard_name' => 'web']);
        $roleInformante->givePermissionTo([
            'indicadores.ver',
            'indicadores.crear',
            'indicadores.editar'
        ]);

        // 4. Revisor
        $roleRevisor = Role::create(['name' => 'Revisor', 'guard_name' => 'web']);
        $roleRevisor->givePermissionTo([
            'indicadores.ver',
            'indicadores.editar'
        ]);

        // 5. Observador
        $roleObservador = Role::create(['name' => 'Observador', 'guard_name' => 'web']);
        $roleObservador->givePermissionTo([
            'indicadores.ver'
        ]);

        // Asignar rol de Control de Gestión al usuario con ID 1 (admin principal)
        $admin = Usuario::find(1);
        if ($admin) {
            $admin->assignRole('Control de Gestión');
        }

        // Asignar rol de Jefatura de División al usuario con ID 21 (Victoria Parra según tus datos)
        // $jefatura = Usuario::find(21);
        // if ($jefatura) {
        //     $jefatura->assignRole('Jefatura de División');
        // }

        // Asignar rol de Informante a los usuarios con perfil 3 (según tus datos)
        //$informantes = Usuario::where('cod_perfil', 3)->get();
        // $informantes = Usuario::find(2)->get();
        // foreach ($informantes as $informante) {
        //     $informante->assignRole('Informante');
        // }
    }
}
