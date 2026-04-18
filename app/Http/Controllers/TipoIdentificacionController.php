<?php

namespace App\Http\Controllers;

use App\Models\TipoIdentificacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TipoIdentificacionController - CRUD (mismo patrón que api-matriculas).
 */
class TipoIdentificacionController extends Controller
{
    public function listar(): JsonResponse
    {
        try {
            $arrTipos = TipoIdentificacion::get();

            return response()->json($arrTipos);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            $obTipo = TipoIdentificacion::find($id);

            return response()->json($obTipo);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'nombre' => 'required|string',
                'mascara' => 'required|string',
            ]);

            TipoIdentificacion::create($valido);

            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'id_tipo_identificacion' => 'required|integer',
                'nombre' => 'required|string',
                'mascara' => 'required|string',
            ]);

            $tipo = TipoIdentificacion::find($request['id_tipo_identificacion']);

            if ($tipo) {
                $tipo->update($valido);

                return response()->json(1);
            }

            return response()->json(0, 404);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
