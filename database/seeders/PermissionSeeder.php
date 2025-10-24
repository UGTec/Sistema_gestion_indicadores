<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'indicadores.cerrar',
            'indicadores.completar',
            'indicadores.reabrir',
            'indicadores.restaurar',
            'indicadores.eliminar_definitivo',
        ];

        // Permisos para Indicadores Mensuales
        $indicadorMensualPermissions = [
            'indicadores_mensuales.ver',
            'indicadores_mensuales.crear',
            'indicadores_mensuales.editar',
            'indicadores_mensuales.eliminar',
            'indicadores_mensuales.revisar',
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

        $iframePermissions = [
            'iframe.ver',
            'iframe.crear',
            'iframe.editar',
            'iframe.eliminar',
        ];

        $archivoPermissions = [
            'archivos.ver',
            'archivos.crear',
            'archivos.editar',
            'archivos.eliminar',
        ];

        // Combinar todos los permisos
        $allPermissions = array_merge(
            $indicadorPermissions,
            $indicadorMensualPermissions,
            $usuarioPermissions,
            $departamentoPermissions,
            $estadoUsuarioPermissions,
            $rolePermissions,
            $permissionPermissions,
            $iframePermissions,
            $archivoPermissions,
        );

        // Crear permisos en la base de datos
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear roles y asignar permisos según los perfiles del sistema

        // 1. Control de Gestión (todos los permisos)
        $roleControlGestion = Role::firstOrCreate(['name' => 'Control de Gestión', 'guard_name' => 'web']);
        $roleControlGestion->givePermissionTo($allPermissions);

        // 2. Jefatura de División
        $roleJefatura = Role::firstOrCreate(['name' => 'Jefatura de División', 'guard_name' => 'web']);
        $roleJefatura->givePermissionTo([
            'indicadores.ver',
            'archivos.ver',
            //'departamentos.ver',
            //'usuarios.ver',
        ]);

        // 3. Informante
        $roleInformante = Role::firstOrCreate(['name' => 'Informante', 'guard_name' => 'web']);
        $roleInformante->givePermissionTo([
            'indicadores.ver',
            //'indicadores.crear',
            'indicadores.editar',
            'indicadores.completar',
            'indicadores_mensuales.ver',
            'indicadores_mensuales.crear',
            'indicadores_mensuales.editar',
            'indicadores_mensuales.eliminar',
        ]);

        // 4. Revisor
        $roleRevisor = Role::firstOrCreate(['name' => 'Revisor', 'guard_name' => 'web']);
        $roleRevisor->givePermissionTo([
            'indicadores.ver',
            'indicadores.editar',
            'indicadores.completar',
        ]);

        // 5. Observador / Auditor
        $roleObservador = Role::firstOrCreate(['name' => 'Observador', 'guard_name' => 'web']);
        $roleObservador->givePermissionTo([
            'indicadores.ver',
        ]);

        // Asignar rol de Control de Gestión al usuario con ID 1 (admin principal)
        $admin = Usuario::find(1);
        if ($admin) {
            $admin->assignRole('Control de Gestión');
        }
    }
}
