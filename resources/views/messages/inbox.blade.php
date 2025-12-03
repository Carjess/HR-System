<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-900 dark:text-white leading-tight">
            {{ __('Bandeja de Entrada') }}
        </h2>
    </x-slot>

    <!-- Contenedor principal -->
    <div class="h-[calc(100vh-140px)] flex overflow-hidden bg-white dark:bg-gray-800 shadow-xl m-4 sm:m-6 rounded-2xl border border-gray-200 dark:border-gray-700">
        
        <!-- 1. BARRA LATERAL (LISTA) -->
        <div class="w-1/3 md:w-1/4 border-r border-gray-200 dark:border-gray-700 flex flex-col bg-gray-50 dark:bg-gray-900/50">
            
            <!-- Filtros -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex bg-gray-200 dark:bg-gray-700 rounded-xl p-1">
                    <a href="{{ route('messages.inbox', ['filter' => 'all']) }}" 
                       class="flex-1 text-center py-2 text-sm font-bold rounded-lg transition-all {{ $filter === 'all' ? 'bg-white text-primary-600 shadow-sm dark:bg-gray-600 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                        Todos
                    </a>
                    <a href="{{ route('messages.inbox', ['filter' => 'mine']) }}" 
                       class="flex-1 text-center py-2 text-sm font-bold rounded-lg transition-all {{ $filter === 'mine' ? 'bg-white text-primary-600 shadow-sm dark:bg-gray-600 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                        Mis Chats
                    </a>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                @forelse($employees as $emp)
                    <a href="{{ route('messages.inbox', ['filter' => $filter, 'user_id' => $emp->id]) }}" 
                       class="block p-4 transition-colors border-b border-gray-100 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-700 {{ isset($selectedConversation) && $selectedConversation->id === $emp->id ? 'bg-white dark:bg-gray-800 border-l-4 border-l-primary-500' : 'border-l-4 border-l-transparent' }}">
                        <div class="flex items-center gap-3">
                            <!-- Avatar con Iniciales -->
                            <div class="h-10 w-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-white shadow-sm {{ isset($selectedConversation) && $selectedConversation->id === $emp->id ? 'bg-primary-500' : 'bg-secondary-400' }}">
                                {{ substr($emp->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $emp->name }}</h4>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $emp->position->name ?? 'Sin Cargo' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400 text-sm flex flex-col items-center">
                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>No hay mensajes {{ $filter === 'mine' ? 'tuyos' : '' }} aún.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. ÁREA DE CHAT (DERECHA) -->
        <div class="flex-1 flex flex-col bg-white dark:bg-gray-800 relative">
            @if($selectedConversation)
                <!-- Cabecera del Chat -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50/80 dark:bg-gray-900/40 backdrop-blur-sm">
                    
                    <!-- CAMBIO AQUÍ: Envuelto en <a> para ir al perfil -->
                    <a href="{{ route('empleados.show', $selectedConversation->id) }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity group" title="Ir al perfil de {{ $selectedConversation->name }}">
                        <div class="h-10 w-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold border-2 border-white shadow-sm group-hover:border-primary-200 transition-colors">
                            {{ substr($selectedConversation->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">{{ $selectedConversation->name }}</h3>
                            <p class="text-xs text-primary-600 font-semibold uppercase tracking-wider">{{ $selectedConversation->department->name ?? 'General' }}</p>
                        </div>
                    </a>
                    
                    <div class="flex items-center gap-3">
                        <!-- Botón POP-OUT (Convertir a bola y salir) -->
                        <button onclick="popOutChat({{ $selectedConversation->id }})" 
                                class="text-secondary-500 hover:text-primary-600 hover:bg-white p-2 rounded-lg transition-all shadow-sm border border-transparent hover:border-gray-200"
                                title="Minimizar y seguir navegando">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </button>

                        <a href="{{ route('empleados.show', $selectedConversation->id) }}" class="text-sm font-medium text-secondary-500 hover:text-primary-600 transition-colors flex items-center gap-1">
                            Ver Perfil 
                        </a>
                    </div>
                </div>

                <!-- Historial -->
                <div id="inbox-history" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50 dark:bg-gray-900/30">
                    @foreach($messages as $msg)
                        <div class="flex w-full {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] group">
                                <!-- Nombre del remitente (si no soy yo) -->
                                @if($msg->sender_id !== auth()->id())
                                    <p class="text-[10px] font-bold text-secondary-500 mb-1 ml-2 uppercase">{{ $msg->sender->name }}</p>
                                @endif
                                
                                <div class="{{ $msg->sender_id === auth()->id() ? 'bg-primary-600 text-white rounded-2xl rounded-tr-none' : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-2xl rounded-tl-none border border-gray-100 dark:border-gray-600' }} px-5 py-3 shadow-sm text-sm leading-relaxed">
                                    {{ $msg->body }}
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 opacity-0 group-hover:opacity-100 transition-opacity {{ $msg->sender_id === auth()->id() ? 'text-right mr-1' : 'text-left ml-1' }}">
                                    {{ $msg->created_at->format('d M H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Input -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <form action="{{ route('messages.store', $selectedConversation->id) }}" method="POST" class="flex gap-3 max-w-4xl mx-auto">
                        @csrf
                        <input type="hidden" name="subject" value="Chat">
                        <input type="text" name="message" class="flex-1 bg-gray-100 dark:bg-gray-700 border-0 rounded-full px-5 py-3 focus:ring-2 focus:ring-primary-500 dark:text-white shadow-inner" placeholder="Escribe tu respuesta..." required autocomplete="off" autofocus>
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <svg class="w-6 h-6 rotate-90 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Script de Utilidad y Pop-out -->
                <script>
                    const inboxContainer = document.getElementById('inbox-history');
                    if(inboxContainer) inboxContainer.scrollTop = inboxContainer.scrollHeight;

                    // Función para convertir a bola y salir
                    function popOutChat(userId) {
                        fetch(`/chat/open/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        }).then(() => {
                            window.location.href = "{{ route('dashboard') }}";
                        });
                    }
                </script>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <p class="text-lg font-medium text-gray-500">Selecciona una conversación</p>
                    <p class="text-sm">Elige un empleado de la lista para ver el historial.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>