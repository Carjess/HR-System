<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Muestra la sala de chat (Vista completa tradicional).
     * Usada cuando accedes directamente a /chat/{user}
     */
    public function chat(User $user)
    {
        $myId = Auth::id();
        $otherId = $user->id;

        // 1. Evitar chatear con uno mismo
        if ($myId === $otherId) {
            return back();
        }

        // 2. Marcar como leídos los mensajes recibidos
        Message::where('sender_id', $otherId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // 3. Obtener la conversación completa
        $messages = Message::where(function($q) use ($myId, $otherId) {
                $q->where('sender_id', $myId)
                  ->where('receiver_id', $otherId);
            })
            ->orWhere(function($q) use ($myId, $otherId) {
                $q->where('sender_id', $otherId)
                  ->where('receiver_id', $myId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Retornamos la vista (Aquí usamos compact, que pasa $user como $user)
        // Nota: Si usas el componente chat.blade.php directamente aquí, asegúrate de las variables.
        // Pero esta función 'chat' suele ser para una página dedicada, no el widget.
        return view('messages.chat', compact('user', 'messages'));
    }

    /**
     * Envía un nuevo mensaje.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'subject' => 'Chat',
            'body' => $request->message,
            'is_read' => false,
            'allow_reply' => true
        ]);

        // Volvemos atrás (recarga para mostrar el mensaje nuevo)
        return back();
    }

    // --- FUNCIONES PARA EL CHAT GLOBAL (WIDGET FLOTANTE) ---

    /**
     * Activa el chat global con un usuario.
     * SOPORTA AJAX: Si se llama desde JS, devuelve HTML sin recargar.
     */
    public function openChat(Request $request, User $user)
    {
        // 1. Siempre guardamos la sesión para que persista al navegar
        session(['active_chat_user_id' => $user->id]);
        
        // 2. DETECCIÓN INTELIGENTE: ¿Es una petición AJAX (JSON)?
        if ($request->ajax() || $request->wantsJson()) {
            
            $myId = Auth::id();
            $targetId = $user->id;

            // Buscamos los mensajes (misma lógica que usamos en el AppServiceProvider)
            $messages = Message::where(function($q) use ($targetId, $myId) {
                $q->where('sender_id', $myId)->where('receiver_id', $targetId);
            })->orWhere(function($q) use ($targetId, $myId) {
                $q->where('sender_id', $targetId)->where('receiver_id', $myId);
            })->orderBy('created_at', 'asc')->get();

            // Renderizamos SOLO el componente visual ('messages.chat') y lo convertimos a texto HTML
            // IMPORTANTE: Pasamos 'empleado' => $user porque chat.blade.php espera la variable $empleado
            $html = view('messages.chat', ['empleado' => $user, 'messages' => $messages])->render();
            
            // Devolvemos el HTML en un JSON para que Javascript lo pegue en el body
            return response()->json(['html' => $html]);
        }
        
        // 3. Fallback: Si por alguna razón no es Ajax, recargamos la página normalmente
        return back();
    }

    /**
     * Cierra el chat global.
     */
    public function closeChat()
    {
        // Borramos la variable de sesión para que no aparezca al recargar
        session()->forget('active_chat_user_id');
        
        return response()->json(['status' => 'closed']);
    }
}