<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoBeneficio extends Model
{
    use HasFactory;

    protected $table = 'empleado_beneficio';
    protected $primaryKey = 'id_emp_bene';
    protected $fillable = [
        'id_emp_bene',
        'id_emp',
        'id_bene',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_emp');
    }

    public function beneficio()
    {
        return $this->belongsTo(Beneficio::class, 'id_bene');
    }

    public $timestamps = false;

}
