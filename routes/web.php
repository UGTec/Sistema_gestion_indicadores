<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EstadoUsuarioController;
use App\Http\Controllers\IndicadorMensualController;
use App\Http\Controllers\TipoIndicadorController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('usuarios', UsuarioController::class);
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('estados', EstadoUsuarioController::class)
        ->parameters(
            [
                'estados' => 'estado'
            ]
        );
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('permisos', PermissionController::class)
        ->parameters(
            [
                'permisos' => 'permission'
            ]
        )
        ->except(['show']);
    // Indicadores
    Route::resource('indicadores', IndicadorController::class)
        ->parameters(
            [
                'indicadores' => 'indicador'
            ]
        );
    Route::prefix('indicadores/{indicador}')->group(function () {
        Route::resource('registros', IndicadorMensualController::class)
            ->except(['index', 'show'])
            ->names([
                'create'  => 'indicadores.registros.create',
                'store'   => 'indicadores.registros.store',
                'edit'    => 'indicadores.registros.edit',
                'update'  => 'indicadores.registros.update',
                'destroy' => 'indicadores.registros.destroy'
            ]);
    });
    // Tipos de Indicadores
    Route::resource('tipos_indicador', TipoIndicadorController::class)
        ->parameters([
            'tipo_indicador' => 'tipo'
    ]);
});
