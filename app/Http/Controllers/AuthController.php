<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'acceso' => 'required|string',
            'secreto' => 'required|string',
        ]);

        if (! $token = Auth::attempt(['acceso' => $credenciales['acceso'], 'password' => $credenciales['secreto']])) {
            return response()->json(['mensaje' => 'Credenciales incorrectos.'], 401);
        }

        if (Auth::user()->estado !== 1) {
            Auth::logout();

            return response()->json(['mensaje' => 'Credenciales incorrectos.'], 401);
        }

        return $this->UsuarioLogeado($token);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['mensaje' => 'Sesión cerrada correctamente.']);
    }

    public function me()
    {
        $user = Auth::user();

        return response()->json([
            'id_usuario' => $user->id_usuario,
            'nombre' => $user->nombre,
            'apellidos' => $user->apellidos,
            'acceso' => $user->acceso,
            'estado' => $user->estado,
        ]);
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::parseToken()->refresh();
        } catch (TokenExpiredException $e) {
            return response()->json(['mensaje' => 'Token expirado.'], 401);
        } catch (JWTException $e) {
            return response()->json(['mensaje' => 'No se pudo renovar el token.'], 500);
        }

        return $this->UsuarioLogeado($token);
    }

    private function UsuarioLogeado(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'usuario' => [
                'id_usuario' => Auth::user()->id_usuario,
                'nombre' => Auth::user()->nombre,
                'apellidos' => Auth::user()->apellidos,
                'acceso' => Auth::user()->acceso,
            ],
        ]);
    }
}
