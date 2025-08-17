<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\IframeController;
use App\Http\Controllers\UsuarioController;
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
    // iframe para Power BI
    Route::resource('iframes', IframeController::class);
    Route::get('iframe/{iframe}', [IframeController::class, 'display'])
        ->name('iframe.display')
        ->where('iframe', '[0-9]+');
    Route::get('api/iframe/active', [IframeController::class, 'getActive'])
        ->name('iframe.active');
});
