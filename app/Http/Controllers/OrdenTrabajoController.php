<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoTarea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenTrabajoController extends Controller
{
    private const RELACIONES = [
        'empleado.tipoIdentificacion',
        'estadoOrden',
        'ordenTrabajoTareas.tarea',
    ];

    public function listar(): JsonResponse
    {
        try {
            return response()->json(
                OrdenTrabajo::with(self::RELACIONES)->get()
            );
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            return response()->json(
                OrdenTrabajo::with(self::RELACIONES)->find($id)
            );
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'empleado' => 'required|array',
                'empleado.id_empleado' => 'required|integer|exists:tbl_empleado,id_empleado',
                'estado_orden' => 'required|array',
                'estado_orden.id_estado_orden' => 'required|integer|exists:tbl_estado_orden,id_estado_orden',
                'fecha' => 'required|date',
                'descripcion' => 'required|string',
                'total_horas' => 'required|numeric|min:0',
                'estado' => 'required|integer',
                'tareas' => 'nullable|array',
                'tareas.*.tarea' => 'required_with:tareas|array',
                'tareas.*.tarea.id_tarea' => 'required_with:tareas.*.tarea|integer|exists:tbl_tarea,id_tarea',
                'tareas.*.horas' => 'required_with:tareas|numeric|min:0',
                'tareas.*.observacion' => 'nullable|string',
            ]);

            DB::transaction(function () use ($valido, $request) {
                $orden = OrdenTrabajo::create([
                    'id_empleado' => $request['empleado']['id_empleado'],
                    'id_estado_orden' => $request['estado_orden']['id_estado_orden'],
                    'fecha' => $valido['fecha'],
                    'descripcion' => $valido['descripcion'],
                    'total_horas' => $valido['total_horas'],
                    'estado' => $valido['estado'],
                ]);

                if (! empty($request['tareas'])) {
                    foreach ($request['tareas'] as $fila) {
                        OrdenTrabajoTarea::create([
                            'id_orden_trabajo' => $orden->id_orden_trabajo,
                            'id_tarea' => $fila['tarea']['id_tarea'],
                            'horas' => $fila['horas'],
                            'observacion' => $fila['observacion'] ?? null,
                        ]);
                    }
                }
            });

            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'id_orden_trabajo' => 'required|integer|exists:tbl_orden_trabajo,id_orden_trabajo',
                'empleado' => 'required|array',
                'empleado.id_empleado' => 'required|integer|exists:tbl_empleado,id_empleado',
                'estado_orden' => 'required|array',
                'estado_orden.id_estado_orden' => 'required|integer|exists:tbl_estado_orden,id_estado_orden',
                'fecha' => 'required|date',
                'descripcion' => 'required|string',
                'total_horas' => 'required|numeric|min:0',
                'estado' => 'required|integer',
                'tareas' => 'nullable|array',
                'tareas.*.tarea' => 'required_with:tareas|array',
                'tareas.*.tarea.id_tarea' => 'required_with:tareas.*.tarea|integer|exists:tbl_tarea,id_tarea',
                'tareas.*.horas' => 'required_with:tareas|numeric|min:0',
                'tareas.*.observacion' => 'nullable|string',
            ]);

            $orden = OrdenTrabajo::find($request['id_orden_trabajo']);
            if (! $orden) {
                return response()->json(0, 404);
            }

            DB::transaction(function () use ($orden, $valido, $request) {
                $orden->update([
                    'id_empleado' => $request['empleado']['id_empleado'],
                    'id_estado_orden' => $request['estado_orden']['id_estado_orden'],
                    'fecha' => $valido['fecha'],
                    'descripcion' => $valido['descripcion'],
                    'total_horas' => $valido['total_horas'],
                    'estado' => $valido['estado'],
                ]);

                if ($request->exists('tareas')) {
                    OrdenTrabajoTarea::where('id_orden_trabajo', $orden->id_orden_trabajo)->delete();
                    foreach ($request['tareas'] ?? [] as $fila) {
                        OrdenTrabajoTarea::create([
                            'id_orden_trabajo' => $orden->id_orden_trabajo,
                            'id_tarea' => $fila['tarea']['id_tarea'],
                            'horas' => $fila['horas'],
                            'observacion' => $fila['observacion'] ?? null,
                        ]);
                    }
                }
            });

            return response()->json(1, 200);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
