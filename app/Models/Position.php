<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\User;

class Position extends Model
{
    
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;

    public function department()
{
    // Un puesto pertenece a un departamento
    return $this->belongsTo(Department::class);
}

/**
 * Obtener los empleados que tienen este puesto.
 */
public function users()
{
    // Un puesto puede tener muchos empleados (users)
    return $this->hasMany(User::class);
}
}
