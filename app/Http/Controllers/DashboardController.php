<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\EstadoDeOrden;
use App\Models\Tarea;
use App\Models\TipoIdentificacion;
use Illuminate\Http\JsonResponse;

/**
 * DashboardController - resumen para la pantalla de inicio (patrón Example).
 */
class DashboardController extends Controller
{
    /**
     * GET /api/dashboard/resumen
     *
     * Conteos alineados con el dominio del proyecto: empleados y tareas activos (estado = 1),
     * catálogos de estados de orden y tipos de identificación (todos los registros).
     */
    public function resumen(): JsonResponse
    {
        return response()->json([
            'empleados' => Empleado::where('estado', 1)->count(),
            'tareas' => Tarea::where('estado', 1)->count(),
            'estados_orden' => EstadoDeOrden::count(),
            'tipos_identificacion' => TipoIdentificacion::count(),
        ]);
    }
}
