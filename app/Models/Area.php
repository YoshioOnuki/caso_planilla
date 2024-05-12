<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'area';
    protected $primaryKey = 'id_area';
    protected $fillable = [
        'id_area',
        'nombre_area',
        'salario_base_area',
        'estado_area',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_area');
    }
    
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_area');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($area) {
            $area->created_by = auth()->id();
        });

        static::updating(function ($area) {
            $area->updated_by = auth()->id();
        });

        static::deleting(function ($area) {
            $area->deleted_by = auth()->id();
            $area->save();
        });
    }
}
