<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Muestra la lista de mensajes recibidos por el usuario (Buzón de Entrada).
     */
    public function index()
    {
        $user = Auth::user();

        // Buscamos los mensajes donde el usuario actual es el RECEPTOR
        // Cargamos la relación 'sender' para mostrar el nombre de quién lo envió
        $messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('messages.index', compact('messages'));
    }

    /**
     * Guardar una respuesta a un mensaje.
     */
    public function reply(Request $request, Message $message)
    {
        // Seguridad: Verificar que el usuario actual es quien recibió el mensaje original
        if (Auth::id() !== $message->receiver_id) {
            abort(403, 'No tienes permiso para responder a este mensaje.');
        }

        $request->validate([
            'reply_body' => 'required|string|max:2000',
        ]);

        // Crear el nuevo mensaje de respuesta
        Message::create([
            'sender_id' => Auth::id(),           // Yo soy el remitente ahora
            'receiver_id' => $message->sender_id, // Le respondo a quien me escribió
            'subject' => 'RE: ' . $message->subject, // Añadimos RE: al asunto
            'body' => $request->reply_body,
            'allow_reply' => true,
        ]);

        return back()->with('status', 'Respuesta enviada correctamente.');
    }

    /**
     * Marcar un mensaje como leído (opcional, se puede llamar vía AJAX o al abrir el modal).
     */
    public function markAsRead(Message $message)
    {
        if (Auth::id() === $message->receiver_id) {
            $message->update(['is_read' => true]);
        }
        return back();
    }
}