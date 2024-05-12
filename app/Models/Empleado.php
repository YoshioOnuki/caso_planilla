<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleado';
    protected $primaryKey = 'id_emp';
    protected $fillable = [
        'id_emp',
        'codigo_emp',
        'salario_emp',
        'fecha_ingreso_emp',
        'fecha_egreso_emp',
        'estado_emp',
        'id_persona',
        'id_area',
        'id_modalidad',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'id_modalidad');
    }

    public function beneficio()
    {
        return $this->belongsToMany(Beneficio::class, 'empleado_beneficio', 'id_emp', 'id_bene');
    }

    public function jornadaLaboral()
    {
        return $this->belongsTo(JornadaLaboral::class, 'id_jornada_lab');
    }

    public function pago()
    {
        return $this->hasMany(Pago::class, 'id_emp');
    }

    public function historialSalario()
    {
        return $this->hasMany(HistorialSalario::class, 'id_emp');
    }


    public function getNombreCompletoAttribute()
    {
        return $this->persona->apellido_pat_persona . ' ' . $this->persona->apellido_mat_persona . ', ' . $this->persona->nombres_persona;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('codigo_emp', 'like', '%' . $search . '%')
            ->orWhere('salario_emp', 'like', '%' . $search . '%')
            ->orWhere('fecha_ingreso_emp', 'like', '%' . $search . '%')
            ->orWhereHas('persona', function ($query) use ($search) {
                $query->where('documento_persona', 'like', '%' . $search . '%')
                    ->orWhere(DB::raw("CONCAT(nombres_persona, ' ', apellido_pat_persona, ' ', apellido_mat_persona)"), 'like', '%' . $search . '%');
            })
            ->orWhereHas('area', function ($query) use ($search) {
                $query->where('nombre_area', 'like', '%' . $search . '%');
            })
            ->orWhereHas('modalidad', function ($query) use ($search) {
                $query->where('nombre_modalidad', 'like', '%' . $search . '%');
            });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($empleado) {
            $empleado->created_by = auth()->id();
        });

        static::updating(function ($empleado) {
            $empleado->updated_by = auth()->id();
        });

        static::deleting(function ($empleado) {
            $empleado->deleted_by = auth()->id();
            $empleado->save();
        });
    }

}
