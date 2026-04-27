<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function listar(): JsonResponse
    {
        try {
            return response()->json(Usuario::all());
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            return response()->json(Usuario::find($id));
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'nombre' => 'required|string',
                'apellidos' => 'required|string',
                'acceso' => 'required|string',
                'secreto' => 'required|string',
                'estado' => 'required|integer',
            ]);

            Usuario::create($valido);

            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $valido = $request->validate([
                'id_usuario' => 'required|integer',
                'nombre' => 'required|string',
                'apellidos' => 'required|string',
                'acceso' => 'required|string',
                'estado' => 'required|integer',
            ]);

            $usuario = Usuario::find($request['id_usuario']);
            if ($usuario) {
                if ($request->has('secreto') && $request['secreto'] != '') {
                    $valido['secreto'] = $request['secreto'];
                }
                $usuario->update($valido);

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
            $usuario['id_usuario'] = $request['id_usuario'];
            $usuario['estado'] = $request['estado'];
            Usuario::findOrFail($usuario['id_usuario'])->update($usuario);

            return response()->json(1, 200);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
