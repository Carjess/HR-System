<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Timesheet extends Model
{
    /** @use HasFactory<\Database\Factories\TimesheetFactory> */
    use HasFactory;
    
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    protected $fillable = [
        'employee_id',
        'date',
        'hours_worked',
        'status',
        ];
}
