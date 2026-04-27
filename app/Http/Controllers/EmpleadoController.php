<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpleadoController extends Controller
{
    public function listar(): JsonResponse
    {
        try {
            $arr = Empleado::with('tipoIdentificacion')->get();

            return response()->json($arr);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            return response()->json(Empleado::with('tipoIdentificacion')->find($id));
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'tipo_identificacion' => 'required|array',
                'tipo_identificacion.id_tipo_identificacion' => 'required|integer|exists:tbl_tipo_identificacion,id_tipo_identificacion',
                'identificacion' => 'required|string|max:20',
                'nombre' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'telefono' => 'required|string|max:20',
                'correo' => ['required', 'email', Rule::unique('tbl_empleado', 'correo')],
                'direccion' => 'required|string|max:255',
                'puesto' => 'required|string|max:100',
                'estado' => 'required|boolean',
            ]);

            $valido['id_tipo_identificacion'] = $request['tipo_identificacion']['id_tipo_identificacion'];
            unset($valido['tipo_identificacion']);
            $valido['estado'] = $request->boolean('estado') ? 1 : 0;

            Empleado::create($valido);

            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'id_empleado' => 'required|integer',
                'tipo_identificacion' => 'required|array',
                'tipo_identificacion.id_tipo_identificacion' => 'required|integer|exists:tbl_tipo_identificacion,id_tipo_identificacion',
                'identificacion' => 'required|string|max:20',
                'nombre' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'telefono' => 'required|string|max:20',
                'correo' => [
                    'required',
                    'email',
                    Rule::unique('tbl_empleado', 'correo')->ignore($request['id_empleado'], 'id_empleado'),
                ],
                'direccion' => 'required|string|max:255',
                'puesto' => 'required|string|max:100',
                'estado' => 'required|integer',
            ]);

            $valido['id_tipo_identificacion'] = $request['tipo_identificacion']['id_tipo_identificacion'];
            unset($valido['tipo_identificacion']);

            $empleado = Empleado::find($request['id_empleado']);
            if ($empleado) {
                $empleado->update($valido);

                return response()->json(1, 200);
            }

            return response()->json(0, 404);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function estado(Request $request): JsonResponse
    {
        try {
            $empleado['id_empleado'] = $request['id_empleado'];
            $empleado['estado'] = $request['estado'] ? 1 : 0;

            Empleado::findOrFail($empleado['id_empleado'])->update(['estado' => $empleado['estado']]);

            return response()->json(1, 200);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
