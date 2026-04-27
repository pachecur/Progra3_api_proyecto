<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    public $timestamps = false;

    protected $table = 'tbl_empleado';

    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'id_empleado',
        'id_tipo_identificacion',
        'identificacion',
        'nombre',
        'apellidos',
        'telefono',
        'correo',
        'estado',
        'direccion',
        'puesto',
    ];

    protected $hidden = ['id_tipo_identificacion'];

    public function tipoIdentificacion(): BelongsTo
    {
        return $this->belongsTo(TipoIdentificacion::class, 'id_tipo_identificacion', 'id_tipo_identificacion');
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class, 'id_empleado', 'id_empleado');
    }
}
