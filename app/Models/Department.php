<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Position;
use App\Models\ContractType; // <-- Relación inversa opcional pero útil

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // Aquí podrías agregar 'description' si quisieras en el futuro
    ];

    /**
     * Obtener los puestos que pertenecen a este departamento.
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Obtener los tipos de contrato asociados a este departamento.
     */
    public function contractTypes()
    {
        return $this->hasMany(ContractType::class);
    }
}