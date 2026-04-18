<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Modelo Usuario - tabla tbl_usuario (autenticación JWT).
 */
class Usuario extends Authenticatable implements JWTSubject
{
    protected $table = 'tbl_usuario';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre',
        'apellidos',
        'acceso',
        'secreto',
        'estado',
    ];

    protected $hidden = ['secreto'];

    public function getAuthPassword(): string
    {
        return $this->secreto;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'acceso' => $this->acceso,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
        ];
    }

    public function setSecretoAttribute(string $value): void
    {
        $this->attributes['secreto'] = Hash::make($value);
    }
}
