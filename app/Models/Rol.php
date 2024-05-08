<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    protected $fillable = [
        'id_rol',
        'nombre_rol',
        'estado_rol'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rol) {
            $rol->created_by = auth()->id();
        });

        static::updating(function ($rol) {
            $rol->updated_by = auth()->id();
        });

        static::deleting(function ($rol) {
            $rol->deleted_by = auth()->id();
            $rol->save();
        });
    }
}
