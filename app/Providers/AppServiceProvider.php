<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// --- IMPORTACIONES NECESARIAS (Antes faltaban estas) ---
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Lógica del CHAT GLOBAL
        // Cada vez que se cargue la plantilla base 'layouts.app', verificamos si hay chat activo en la sesión.
        View::composer('layouts.app', function ($view) {
            // 1. Verificamos si el usuario está logueado Y si hay una sesión de chat abierta
            if (Auth::check() && session()->has('active_chat_user_id')) {
                
                $targetId = session('active_chat_user_id');
                $chatUser = User::find($targetId);

                // 2. Si el usuario con el que chateamos existe, cargamos los mensajes
                if ($chatUser) {
                    // Buscamos mensajes donde (Yo soy emisor Y él receptor) O (Él es emisor Y yo receptor)
                    $messages = Message::where(function($q) use ($targetId) {
                        $q->where('sender_id', Auth::id())->where('receiver_id', $targetId);
                    })->orWhere(function($q) use ($targetId) {
                        $q->where('sender_id', $targetId)->where('receiver_id', Auth::id());
                    })->orderBy('created_at', 'asc')->get();

                    // 3. Inyectamos estas variables ('globalChatUser' y 'globalChatMessages') 
                    // a la vista 'layouts.app' para que estén disponibles en TODAS las páginas.
                    $view->with('globalChatUser', $chatUser)
                         ->with('globalChatMessages', $messages);
                }
            }
        });
    }
}