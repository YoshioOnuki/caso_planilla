<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'persona';
    protected $primaryKey = 'id_persona';
    protected $fillable = [
        'id_persona',
        'documento_persona',
        'nombres_persona',
        'apellido_pat_persona',
        'apellido_mat_persona',
        'genero_persona',
        'fecha_naci_persona',
    ];

    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'id_persona');
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'id_persona');
    }

    public function getSoloPrimerosNombresAttribute()
    {
        $nombres = explode(' ', $this->nombres_persona);
        return $nombres[0] . ' ' . $this->apellido_pat_persona;
    }

    public function getAvatarAttribute()
    {
        return $this->usuario->first()->ruta_foto_usuario ?? 'media/usuario.webp';
    }

    public function scopeNoAdmin($query)
    {
        return $query->whereDoesntHave('usuario', function ($query) {
            $query->where('id_rol', 1);
        });
    }

    // persona que tenga en la tabla empleados un registro con estado 0
    public function scopeEmpleadoInactivo($query)
    {
        return $query->whereHas('empleado', function ($query) {
            $query->where('estado_emp', 0);
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($persona) {
            $persona->created_by = auth()->id();
        });

        static::updating(function ($persona) {
            $persona->updated_by = auth()->id();
        });

        static::deleting(function ($persona) {
            $persona->deleted_by = auth()->id();
            $persona->save();
        });
    }
}
