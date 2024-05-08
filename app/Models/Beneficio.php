<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'beneficio';
    protected $primaryKey = 'id_bene';
    protected $fillable = [
        'id_bene',
        'nombre_bene',
        'operacion_bene',
        'mes_bene',
        'estado_bene',
    ];

    public function empleado()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_beneficio', 'id_bene', 'id_emp');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($beneficio) {
            $beneficio->created_by = auth()->id();
        });

        static::updating(function ($beneficio) {
            $beneficio->updated_by = auth()->id();
        });

        static::deleting(function ($beneficio) {
            $beneficio->deleted_by = auth()->id();
            $beneficio->save();
        });
    }
}
