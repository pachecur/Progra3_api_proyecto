<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoDeOrden extends Model
{
    public $timestamps = false;

    protected $table = 'tbl_estado_orden';

    protected $primaryKey = 'id_estado_orden';

    protected $fillable = [
        'id_estado_orden',
        'nombre',
    ];

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class, 'id_estado_orden', 'id_estado_orden');
    }
}
