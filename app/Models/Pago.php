<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pago';
    protected $primaryKey = 'id_pago';
    protected $fillable = [
        'id_pago',
        'monto_pago',
        'fecha_pago',
        'id_emp',
        'id_area',
        'id_historial',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_emp');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function historialSalario()
    {
        return $this->belongsTo(HistorialSalario::class, 'id_historial');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pago) {
            $pago->created_by = auth()->id();
        });

        static::updating(function ($pago) {
            $pago->updated_by = auth()->id();
        });

        static::deleting(function ($pago) {
            $pago->deleted_by = auth()->id();
            $pago->save();
        });
    }
}
