<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use App\Models\Department; 

class ContractType extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'name',
        'description',   // Nuevo campo
        'salary',        // Nuevo campo (salario base sugerido)
        'department_id', // Nuevo campo (relación con departamento)
    ];

    /**
     * Obtener los contratos asociados a este tipo.
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'contract_type_id');
    }

    /**
     * Obtener el departamento al que pertenece este tipo de contrato.
     */
    public function department()
    {
        // Un tipo de contrato "pertenece a" un departamento específico
        return $this->belongsTo(Department::class);
    }
}