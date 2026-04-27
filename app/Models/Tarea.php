<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarea extends Model
{
    public $timestamps = false;

    protected $table = 'tbl_tarea';

    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'id_tarea',
        'nombre',
        'descripcion',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    public function ordenTrabajoTareas(): HasMany
    {
        return $this->hasMany(OrdenTrabajoTarea::class, 'id_tarea', 'id_tarea');
    }
}
