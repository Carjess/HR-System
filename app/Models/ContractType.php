<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class ContractType extends Model
{
    /** @use HasFactory<\Database\Factories\ContractTypeFactory> */
    use HasFactory;
    protected $fillable = ['name'];
    
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'contract_type_id');
    }
}
