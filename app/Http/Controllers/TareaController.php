<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function listar(): JsonResponse
    {
        try {
            return response()->json(Tarea::get());
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            return response()->json(Tarea::find($id));
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'nombre' => 'required|string|max:100',
                'descripcion' => 'required|string',
                'hora_inicio' => 'required|date_format:H:i:s',
                'hora_fin' => 'required|date_format:H:i:s|after:hora_inicio',
                'estado' => 'required|boolean',
            ]);

            $valido['estado'] = $request->boolean('estado') ? 1 : 0;

            Tarea::create($valido);

            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'id_tarea' => 'required|integer',
                'nombre' => 'required|string|max:100',
                'descripcion' => 'required|string',
                'hora_inicio' => 'required|date_format:H:i:s',
                'hora_fin' => 'required|date_format:H:i:s|after:hora_inicio',
                'estado' => 'required|integer',
            ]);

            $tarea = Tarea::find($request['id_tarea']);
            if ($tarea) {
                $tarea->update($valido);

                return response()->json(1);
            }

            return response()->json(0, 404);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function estado(Request $request): JsonResponse
    {
        try {
            $payload['id_tarea'] = $request['id_tarea'];
            $payload['estado'] = $request['estado'] ? 1 : 0;

            Tarea::findOrFail($payload['id_tarea'])->update(['estado' => $payload['estado']]);

            return response()->json(1, 200);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
