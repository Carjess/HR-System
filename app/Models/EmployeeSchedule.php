<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;  
use App\Models\Shift;

class EmployeeSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeScheduleFactory> */
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Obtener el turno de este horario.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
