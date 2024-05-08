<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JornadaLaboral extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'jornada_laboral';
    protected $primaryKey = 'id_jornada_lab';
    protected $fillable = [
        'nombre_jornada_lab',
        'estado_jornada_lab',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_jornada_lab');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre_jornada_lab', 'LIKE', '%' . $search . '%');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado_jornada_lab', 1);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jornada_laboral) {
            $jornada_laboral->created_by = auth()->id();
        });
        static::updating(function ($jornada_laboral) {
            $jornada_laboral->updated_by = auth()->id();
        });
        static::deleting(function ($jornada_laboral) {
            $jornada_laboral->deleted_by = auth()->id();
            $jornada_laboral->save();
        });
    }



}
