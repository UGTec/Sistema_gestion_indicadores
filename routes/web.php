<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\IframeController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EstadoUsuarioController;
use App\Http\Controllers\IndicadorMensualController;

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

    // Rutas adicionales para manejar estados
    Route::post('indicadores/{indicador}/cerrar', [IndicadorController::class, 'cerrar'])
        ->name('indicadores.cerrar');

    Route::post('indicadores/{indicador}/completar', [IndicadorController::class, 'completar'])
        ->name('indicadores.completar');

    Route::post('indicadores/{indicador}/reabrir', [IndicadorController::class, 'reabrir'])
        ->name('indicadores.reabrir');
    // Rutas para Indicadores Mensuales
    Route::prefix('indicadores/{indicador}/mensuales')->name('indicadores-mensuales.')->group(function () {
        Route::get('/create', [IndicadorMensualController::class, 'create'])
            ->name('create')
            ->middleware('can:create,App\Models\IndicadorMensual');

        Route::post('/', [IndicadorMensualController::class, 'store'])
            ->name('store')
            ->middleware('can:create,App\Models\IndicadorMensual');

        Route::get('/{mensual}/edit', [IndicadorMensualController::class, 'edit'])
            ->name('edit')
            ->middleware('can:update,mensual');

        Route::put('/{mensual}', [IndicadorMensualController::class, 'update'])
            ->name('update')
            ->middleware('can:update,mensual');

        Route::delete('/{mensual}', [IndicadorMensualController::class, 'destroy'])
            ->name('destroy')
            ->middleware('can:delete,mensual');
    });

    // iframe para Power BI
    Route::resource('iframes', IframeController::class);
    Route::get('iframe/{iframe}', [IframeController::class, 'display'])
        ->name('iframe.display')
        ->where('iframe', '[0-9]+');
    Route::get('api/iframe/active', [IframeController::class, 'getActive'])
        ->name('iframe.active');

    Route::get('/archivos/{archivo}/download', [ArchivoController::class, 'download'])
        ->name('archivos.download');

    Route::delete('/archivos/{archivo}', [ArchivoController::class, 'destroy'])
        ->name('archivos.destroy');
});
