<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Position; // <-- Asegúrate de que esto esté importado

class ContractType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'salary',
        'department_id',
        'position_id', // <-- Asegúrate de que este campo esté aquí
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
        return $this->belongsTo(Department::class);
    }

    /**
     * Obtener el cargo al que pertenece este tipo de contrato.
     * ESTA ES LA FUNCIÓN QUE FALTABA Y CAUSABA EL ERROR.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}