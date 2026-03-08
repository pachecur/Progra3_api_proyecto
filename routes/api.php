<?php

use App\Http\Controllers\TareaController;
use App\Http\Controllers\TipoIdentificacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('tipos-identificacion')->group(function () {
    Route::get('listar', [TipoIdentificacionController::class, 'listar']);
    Route::get('consultar/{id}', [TipoIdentificacionController::class, 'consultar']);
    Route::post('guardar', [TipoIdentificacionController::class, 'guardar']);
    Route::put('actualizar/{id}', [TipoIdentificacionController::class, 'actualizar']);
});

Route::prefix('tareas')->group(function () {
    Route::get('listar', [TareaController::class, 'listar']);
    Route::get('consultar/{id}', [TareaController::class, 'consultar']);
    Route::post('guardar', [TareaController::class, 'guardar']);
    Route::put('actualizar/{id}', [TareaController::class, 'actualizar']);
});
