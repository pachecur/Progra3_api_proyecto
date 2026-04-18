<?php

namespace App\Http\Controllers;

use App\Models\EstadoDeOrden;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * EstadoOrdenController - CRUD estados de orden (patrón Example).
 */
class EstadoOrdenController extends Controller
{
    public function listar(): JsonResponse
    {
        try {
            return response()->json(EstadoDeOrden::get());
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            return response()->json(EstadoDeOrden::find($id));
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'nombre' => 'required|string|max:100',
            ]);

            EstadoDeOrden::create($valido);

            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'id_estado_orden' => 'required|integer',
                'nombre' => 'required|string|max:100',
            ]);

            $estado = EstadoDeOrden::find($request['id_estado_orden']);
            if ($estado) {
                $estado->update($valido);

                return response()->json(1);
            }

            return response()->json(0, 404);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
