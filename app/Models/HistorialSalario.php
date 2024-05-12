<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSalario extends Model
{
    use HasFactory;

    protected $table = 'historial_salario';
    protected $primaryKey = 'id_historial';
    protected $fillable = [
        'id_historial',
        'salario_act_historial',
        'salario_ant_historial',
        'fecha_cambio_historial',
        'estado_historial',
        'id_emp',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_emp');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_historial');
    }

    public $timestamps = false;

}
