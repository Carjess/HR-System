<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'admin_response',
    ];

    /**
     * Obtener el empleado al que pertenece esta solicitud.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}