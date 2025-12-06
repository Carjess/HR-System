<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'is_read',
        'allow_reply',
    ];

    /**
     * Conversión automática de tipos.
     */
    protected $casts = [
        'is_read' => 'boolean',
        'allow_reply' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Relación: Usuario que envía el mensaje.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relación: Usuario que recibe el mensaje.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}