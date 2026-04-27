<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\EstadoDeOrden;
use App\Models\Tarea;
use App\Models\TipoIdentificacion;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
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
