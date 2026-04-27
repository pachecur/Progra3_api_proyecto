<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenTrabajo extends Model
{
    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected $table = 'tbl_orden_trabajo';

    protected $primaryKey = 'id_orden_trabajo';

    protected $fillable = [
        'id_empleado',
        'id_estado_orden',
        'fecha',
        'descripcion',
        'total_horas',
        'estado',
    ];

    protected $hidden = [
        'id_empleado',
        'id_estado_orden',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
            'total_horas' => 'decimal:2',
            'estado' => 'integer',
        ];
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    public function estadoOrden(): BelongsTo
    {
        return $this->belongsTo(EstadoDeOrden::class, 'id_estado_orden', 'id_estado_orden');
    }

    public function ordenTrabajoTareas(): HasMany
    {
        return $this->hasMany(OrdenTrabajoTarea::class, 'id_orden_trabajo', 'id_orden_trabajo');
    }
}
