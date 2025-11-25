<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
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
     * Obtener el usuario que envió el mensaje.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Obtener el usuario que recibió el mensaje.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}