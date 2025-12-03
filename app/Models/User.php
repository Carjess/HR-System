<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // IMPORTANTE: Agregado para las relaciones

use App\Models\Position;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\LeaveRequest;
use App\Models\Payslip;
use App\Models\EmployeeSchedule;
use App\Models\Message; // Aseguramos que reconozca el modelo Message

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // --- RELACIONES EXISTENTES ---

    public function position()
    {
        // Un empleado pertenece a un puesto
        return $this->belongsTo(Position::class);
    }

    public function contracts()
    {
        // Un empleado TIENE MUCHOS contratos (historial)
        return $this->hasMany(Contract::class, 'employee_id');
    }

    /**
     * Obtener las hojas de horas del empleado.
     */
    public function timesheets()
    {
        // Un empleado TIENE MUCHAS hojas de horas
        return $this->hasMany(Timesheet::class, 'employee_id');
    }

    /**
     * Obtener las solicitudes de ausencia del empleado.
     */
    public function leaveRequests()
    {
        // Un empleado TIENE MUCHAS solicitudes
        return $this->hasMany(LeaveRequest::class, 'employee_id');
    }

    /**
     * Obtener las nóminas del empleado.
     */
    public function payslips()
    {
        // Un empleado TIENE MUCHAS nóminas
        return $this->hasMany(Payslip::class, 'employee_id');
    }

    /**
     * Obtener los horarios asignados del empleado.
     */
    public function schedules()
    {
        // Un empleado TIENE MUCHOS horarios
        return $this->hasMany(EmployeeSchedule::class, 'employee_id');
    }

    // --- NUEVAS RELACIONES PARA EL CHAT (INBOX) ---

    /**
     * Mensajes enviados por el usuario.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Mensajes recibidos por el usuario.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * RELACIÓN ESPECIAL: Todos los mensajes (enviados O recibidos).
     * Esta es la relación que busca el método 'inbox' para filtrar usuarios con actividad.
     */
    public function messages()
    {
        // Retorna una relación base sobre los mensajes enviados, pero añade la condición OR
        // para incluir también los recibidos. Esto permite usar whereHas('messages')
        return $this->hasMany(Message::class, 'sender_id')->orWhere('receiver_id', $this->id);
    }

    // --- CONFIGURACIÓN DEL MODELO ---

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'direccion',
        'fecha_contratacion',
        'position_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}