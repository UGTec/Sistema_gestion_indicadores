<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FlujoController;
use App\Http\Controllers\IframeController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EstadoUsuarioController;

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
    Route::resource('indicadores', IndicadorController::class);
    Route::prefix('indicadores/{indicador}/reportes/{año}/{mes}')->group(function () {
        Route::get('crear', [ReporteController::class, 'create'])->name('reportes.create');
        Route::post('/', [ReporteController::class, 'store'])->name('reportes.store');
        Route::get('/', [ReporteController::class, 'show'])->name('reportes.show');

        // Flujo
        Route::post('enviar-a-revisor', [FlujoController::class, 'enviarARevisor'])
            ->name('reportes.enviarRevisor');
        Route::post('revisor', [FlujoController::class, 'revisorAccion'])
            ->name('reportes.revisor');
        Route::post('control', [FlujoController::class, 'controlAccion'])
            ->name('reportes.control');
        Route::post('jefatura', [FlujoController::class, 'jefaturaAccion'])
            ->name('reportes.jefatura');
    });
    Route::get('adjuntos/{adjunto}/descargar', [ReporteController::class, 'descargarAdjunto'])
        ->name('adjuntos.descargar');

    // iframe para Power BI
    Route::resource('iframes', IframeController::class);
    Route::get('iframe/{iframe}', [IframeController::class, 'display'])
        ->name('iframe.display')
        ->where('iframe', '[0-9]+');
    Route::get('api/iframe/active', [IframeController::class, 'getActive'])
        ->name('iframe.active');
});
