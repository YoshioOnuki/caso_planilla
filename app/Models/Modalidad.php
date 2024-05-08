<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modalidad extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'modalidad';
    protected $primaryKey = 'id_modalidad';
    protected $fillable = [
        'id_modalidad',
        'nombre_modalidad',
        'estado_modalidad',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_modalidad');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modalidad) {
            $modalidad->created_by = auth()->id();
        });

        static::updating(function ($modalidad) {
            $modalidad->updated_by = auth()->id();
        });

        static::deleting(function ($modalidad) {
            $modalidad->deleted_by = auth()->id();
            $modalidad->save();
        });
    }
    
}
