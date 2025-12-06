<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Bandeja de Entrada (Inbox).
     * - Admins: Ven todos los chats de empleados (Gestión de Tickets).
     * - Empleados: Ven sus chats con RRHH (Mis Tickets).
     */
    public function inbox(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');
        
        // === LÓGICA PARA ADMINISTRADORES ===
        if ($user->role === 'admin') {
            // Query Base: Empleados que tienen mensajes
            $contactsQuery = User::where('role', '!=', 'admin')
                ->where(function($query) {
                    $query->whereHas('sentMessages')->orWhereHas('receivedMessages');
                });

            // Filtro "Mis Chats"
            if ($filter === 'mine') {
                $contactsQuery->where(function($q) use ($user) {
                    $q->whereHas('receivedMessages', fn($sq) => $sq->where('sender_id', $user->id))
                      ->orWhereHas('sentMessages', fn($sq) => $sq->where('receiver_id', $user->id));
                });
            }
        } 
        // === LÓGICA PARA EMPLEADOS (JESÚS) ===
        else {
            // Query Base: Mostrar solo Administradores con los que he hablado
            $contactsQuery = User::where('role', 'admin')
                ->where(function($q) use ($user) {
                     $q->whereHas('receivedMessages', fn($sq) => $sq->where('sender_id', $user->id))
                       ->orWhereHas('sentMessages', fn($sq) => $sq->where('receiver_id', $user->id));
                });
        }

        // Buscador general
        if ($search) {
            $contactsQuery->where('name', 'like', "%{$search}%");
        }

        // Ejecutar consulta de contactos
        $employees = $contactsQuery->with(['sentMessages' => fn($q) => $q->latest()->limit(1), 'receivedMessages' => fn($q) => $q->latest()->limit(1)])->get();

        // Ordenar por mensaje más reciente
        $employees = $employees->sortByDesc(function($u) {
            $lastSent = $u->sentMessages->first()?->created_at;
            $lastReceived = $u->receivedMessages->first()?->created_at;
            return max($lastSent, $lastReceived) ?? 0;
        });

        // Cargar conversación seleccionada
        $selectedConversation = null;
        $messages = [];
        
        if ($request->has('user_id')) {
            $otherUser = User::find($request->user_id);
            
            // Seguridad Extra: Si soy empleado, solo puedo cargar chats con Admins
            if ($user->role !== 'admin' && $otherUser->role !== 'admin') {
                abort(403);
            }

            if ($otherUser) {
                $selectedConversation = $otherUser;
                // Marcar leídos
                Message::where('sender_id', $otherUser->id)->where('receiver_id', $user->id)->update(['is_read' => true]);
                
                // Cargar mensajes
                $messages = Message::where(function($q) use ($user, $otherUser) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $otherUser->id);
                })->orWhere(function($q) use ($user, $otherUser) {
                    $q->where('sender_id', $otherUser->id)->where('receiver_id', $user->id);
                })->orderBy('created_at', 'asc')->get();
            }
        }

        return view('messages.inbox', compact('employees', 'filter', 'selectedConversation', 'messages', 'search'));
    }

    /**
     * ACCIÓN: Crear Ticket / Contactar RRHH
     * Busca un admin disponible y redirige al chat con él.
     */
    public function createTicket()
    {
        // Buscar el primer administrador del sistema
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return back()->with('error', 'No hay administradores disponibles de RRHH.');
        }

        // Redirigir a la bandeja de entrada con ese chat abierto
        return redirect()->route('messages.inbox', ['user_id' => $admin->id]);
    }

    /**
     * Guardar mensaje (Store).
     */
    public function store(Request $request, User $user)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'subject' => 'Ticket #' . rand(1000,9999),
            'body' => $request->message,
            'is_read' => false,
            'allow_reply' => true
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->route('messages.inbox', ['user_id' => $user->id]);
    }

    // --- WIDGET FLOTANTE (AJAX) ---
    // (Mantenemos esto igual por si usas el widget en otras pantallas)
    public function openChat(Request $request, User $user)
    {
        $currentUser = Auth::user();
        $isAdminChatting = $currentUser->role === 'admin';
        $isTalkingToAdmin = $user->role === 'admin';

        if (!$isAdminChatting && !$isTalkingToAdmin && $currentUser->id !== $user->id) {
             return response()->json(['error' => 'Unauthorized'], 403);
        }

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
    
    // La función chat() ya no es estrictamente necesaria si usas inbox, pero la dejamos por compatibilidad
    public function chat(User $user) {
        return redirect()->route('messages.inbox', ['user_id' => $user->id]);
    }
}