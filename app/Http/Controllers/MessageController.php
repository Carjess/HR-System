<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder; // Importante para consultas avanzadas

class MessageController extends Controller
{
    /**
     * Muestra la sala de chat individual (Vista tradicional).
     */
    public function chat(User $user)
    {
        $myId = Auth::id();
        $otherId = $user->id;

        if ($myId === $otherId) return back();

        // Marcar leídos
        Message::where('sender_id', $otherId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Cargar conversación
        $messages = Message::where(function($q) use ($myId, $otherId) {
                $q->where('sender_id', $myId)->where('receiver_id', $otherId);
            })
            ->orWhere(function($q) use ($myId, $otherId) {
                $q->where('sender_id', $otherId)->where('receiver_id', $myId);
            })
            ->orderBy('created_at', 'asc')->get();

        return view('messages.chat', compact('user', 'messages'));
    }

    /**
     * Guardar mensaje nuevo.
     */
    public function store(Request $request, User $user)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'subject' => 'Chat',
            'body' => $request->message,
            'is_read' => false,
            'allow_reply' => true
        ]);

        return back();
    }

    // --- FUNCIONES DEL WIDGET GLOBAL ---

    public function openChat(Request $request, User $user)
    {
        session(['active_chat_user_id' => $user->id]);
        
        if ($request->ajax() || $request->wantsJson()) {
            $myId = Auth::id();
            $targetId = $user->id;
            
            $messages = Message::where(function($q) use ($targetId, $myId) {
                $q->where('sender_id', $myId)->where('receiver_id', $targetId);
            })->orWhere(function($q) use ($targetId, $myId) {
                $q->where('sender_id', $targetId)->where('receiver_id', $myId);
            })->orderBy('created_at', 'asc')->get();

            $html = view('messages.chat', ['empleado' => $user, 'messages' => $messages])->render();
            return response()->json(['html' => $html]);
        }
        return back();
    }

    public function closeChat()
    {
        session()->forget('active_chat_user_id');
        return response()->json(['status' => 'closed']);
    }

    // --- BANDEJA DE ENTRADA (INBOX) ---
    public function inbox(Request $request)
    {
        $filter = $request->query('filter', 'all'); // 'all' o 'mine'
        $adminId = Auth::id();

        // 1. Base: Usuarios que no sean admin y tengan algún mensaje (Enviado O Recibido)
        // Usamos where(function...) para agrupar las condiciones OR correctamente
        $employeesQuery = User::where('role', '!=', 'admin')
            ->where(function($query) {
                $query->whereHas('sentMessages')
                      ->orWhereHas('receivedMessages');
            });

        // 2. Filtro "Mis Chats"
        if ($filter === 'mine') {
            // Muestra usuarios con los que YO he interactuado (Yo les escribí O ellos me escribieron)
            $employeesQuery->where(function($q) use ($adminId) {
                $q->whereHas('receivedMessages', function ($subQ) use ($adminId) {
                    $subQ->where('sender_id', $adminId); // Mensajes que YO envié
                })->orWhereHas('sentMessages', function ($subQ) use ($adminId) {
                    $subQ->where('receiver_id', $adminId); // Mensajes que YO recibí
                });
            });
        }

        // 3. Carga optimizada (Eager Loading) para la previsualización en la lista
        $employees = $employeesQuery->with(['sentMessages' => function($q) {
            $q->latest()->limit(1);
        }, 'receivedMessages' => function($q) {
            $q->latest()->limit(1);
        }])->get();

        // 4. Ordenar por fecha del último mensaje (el más reciente arriba)
        $employees = $employees->sortByDesc(function($user) {
            $lastSent = $user->sentMessages->first()?->created_at;
            $lastReceived = $user->receivedMessages->first()?->created_at;
            // Si no hay mensajes (caso raro por el filtro anterior), usa una fecha antigua
            return max($lastSent, $lastReceived) ?? 0;
        });

        // 5. Cargar chat seleccionado (si se hizo clic en uno de la lista)
        $selectedConversation = null;
        $messages = [];
        
        if ($request->has('user_id')) {
            $otherUser = User::find($request->user_id);
            if ($otherUser) {
                $selectedConversation = $otherUser;
                // Marcar como leídos los mensajes que este usuario ME envió a MÍ
                Message::where('sender_id', $otherUser->id)
                       ->where('receiver_id', $adminId)
                       ->update(['is_read' => true]);
                
                // Traer historial completo de la conversación
                $messages = Message::where(function($q) use ($adminId, $otherUser) {
                    $q->where('sender_id', $adminId)->where('receiver_id', $otherUser->id);
                })->orWhere(function($q) use ($adminId, $otherUser) {
                    $q->where('sender_id', $otherUser->id)->where('receiver_id', $adminId);
                })->orderBy('created_at', 'asc')->get();
            }
        }

        return view('messages.inbox', compact('employees', 'filter', 'selectedConversation', 'messages'));
    }
}