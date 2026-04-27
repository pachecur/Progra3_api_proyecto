<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenTrabajoTarea extends Model
{
    public $timestamps = false;

    protected $table = 'tbl_orden_trabajo_tarea';

    protected $primaryKey = 'id_orden_trabajo_tarea';

    protected $fillable = [
        'id_orden_trabajo',
        'id_tarea',
        'horas',
        'observacion',
    ];

    protected $hidden = [
        'id_orden_trabajo',
        'id_tarea',
    ];

    protected function casts(): array
    {
        return [
            'horas' => 'decimal:2',
        ];
    }

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(OrdenTrabajo::class, 'id_orden_trabajo', 'id_orden_trabajo');
    }

    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'id_tarea', 'id_tarea');
    }
}
