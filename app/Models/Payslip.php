<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Payslip extends Model
{
    /** @use HasFactory<\Database\Factories\PayslipFactory> */
    use HasFactory;
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'base_salary',
        'total_hours',
        'bonuses',
        'deductions',
        'net_pay',
    ];
    
}
