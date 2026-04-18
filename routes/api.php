<?php

/**
 * Rutas de la API (prefijo /api).
 * Misma organización que api-matriculas: públicas (login) y protegidas (JWT auth:api).
 */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EstadoOrdenController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\TipoIdentificacionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('resumen', [DashboardController::class, 'resumen']);
    });

    Route::prefix('tipo-identificacion')->group(function () {
        Route::get('listar', [TipoIdentificacionController::class, 'listar']);
        Route::get('consultar/{id}', [TipoIdentificacionController::class, 'consultar']);
        Route::post('guardar', [TipoIdentificacionController::class, 'guardar']);
        Route::put('actualizar', [TipoIdentificacionController::class, 'actualizar']);
    });

    Route::prefix('estado-orden')->group(function () {
        Route::get('listar', [EstadoOrdenController::class, 'listar']);
        Route::get('consultar/{id}', [EstadoOrdenController::class, 'consultar']);
        Route::post('guardar', [EstadoOrdenController::class, 'guardar']);
        Route::put('actualizar', [EstadoOrdenController::class, 'actualizar']);
    });

    Route::prefix('tarea')->group(function () {
        Route::get('listar', [TareaController::class, 'listar']);
        Route::get('consultar/{id}', [TareaController::class, 'consultar']);
        Route::post('guardar', [TareaController::class, 'guardar']);
        Route::put('actualizar', [TareaController::class, 'actualizar']);
        Route::patch('estado', [TareaController::class, 'estado']);
    });

    Route::prefix('empleado')->group(function () {
        Route::get('listar', [EmpleadoController::class, 'listar']);
        Route::get('consultar/{id}', [EmpleadoController::class, 'consultar']);
        Route::post('guardar', [EmpleadoController::class, 'guardar']);
        Route::put('actualizar', [EmpleadoController::class, 'actualizar']);
        Route::patch('estado', [EmpleadoController::class, 'estado']);
    });

    Route::prefix('usuario')->group(function () {
        Route::get('listar', [UsuarioController::class, 'listar']);
        Route::get('consultar/{id}', [UsuarioController::class, 'consultar']);
        Route::post('guardar', [UsuarioController::class, 'guardar']);
        Route::put('actualizar', [UsuarioController::class, 'actualizar']);
        Route::patch('estado', [UsuarioController::class, 'estado']);
    });
});
