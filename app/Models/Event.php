<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'type',
        'department_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relación: Un evento pertenece a un departamento (opcional)
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relación: Un evento fue creado por un usuario
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}