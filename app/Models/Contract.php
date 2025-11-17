<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\ContractType;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;
    protected $fillable = [
        'contract_type_id',
        'start_date',
        'end_date',
        'salary',
        'employee_id' // Aunque lo hacemos con la relación, es bueno tenerlo
    ];
    
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function type()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }
}
