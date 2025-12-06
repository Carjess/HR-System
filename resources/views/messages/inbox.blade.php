<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight relative z-50 flex items-center gap-2">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            {{ __('Centro de Soporte & Mensajería') }}
        </h2>
        
        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #CBD5E1; border-radius: 20px; }
            .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #4B5563; }
        </style>
    </x-slot>

    <!-- 
       RESTAURADO: Contenedor con bordes redondeados, sombra y márgenes (m-4 sm:m-6)
       MANTENIENDO: Funcionalidad de búsqueda y chat mejorado.
    -->
    <div class="h-[calc(100vh-150px)] flex overflow-hidden bg-white dark:bg-gray-800 shadow-xl m-2 sm:m-4 rounded-2xl border border-gray-200 dark:border-gray-700">
        
        <!-- 1. BARRA LATERAL (LISTA DE CONVERSACIONES) -->
        <!-- Ajusté el ancho a w-80 md:w-96 para asegurar que el buscador quepa bien, pero dentro del contenedor redondeado -->
        <div class="w-80 md:w-96 border-r border-gray-200 dark:border-gray-700 flex flex-col bg-gray-50 dark:bg-gray-900/50 flex-shrink-0">
            
            <!-- Cabecera Lateral -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-white">Mensajes</h3>
                    <div class="bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $employees->count() }}</div>
                </div>

                <!-- Buscador (Nueva Funcionalidad) -->
                <form method="GET" action="{{ route('messages.inbox') }}" class="relative mb-3">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar empleado..." 
                           class="w-full pl-9 pr-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 placeholder-gray-400 transition-shadow"
                           onchange="this.form.submit()">
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>
                
                <!-- Tabs de Filtro -->
                <div class="flex bg-gray-200 dark:bg-gray-700 rounded-lg p-1">
                    <a href="{{ route('messages.inbox', ['filter' => 'all', 'search' => request('search')]) }}" 
                       class="flex-1 text-center py-1.5 text-xs font-bold rounded-md transition-all {{ $filter === 'all' ? 'bg-white text-primary-700 shadow-sm dark:bg-gray-600 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                        Todos
                    </a>
                    <a href="{{ route('messages.inbox', ['filter' => 'mine', 'search' => request('search')]) }}" 
                       class="flex-1 text-center py-1.5 text-xs font-bold rounded-md transition-all {{ $filter === 'mine' ? 'bg-white text-primary-700 shadow-sm dark:bg-gray-600 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                        Mis Chats
                    </a>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-1">
                @forelse($employees as $emp)
                    <a href="{{ route('messages.inbox', ['filter' => $filter, 'user_id' => $emp->id, 'search' => request('search')]) }}" 
                       class="group flex items-center gap-3 p-3 rounded-xl transition-all {{ isset($selectedConversation) && $selectedConversation->id === $emp->id ? 'bg-white dark:bg-gray-800 shadow-md border-l-4 border-primary-500' : 'hover:bg-white dark:hover:bg-gray-800 border-l-4 border-transparent' }}">
                        
                        <div class="relative">
                            <div class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-white shadow-sm {{ isset($selectedConversation) && $selectedConversation->id === $emp->id ? 'bg-primary-600' : 'bg-gray-400 dark:bg-gray-600' }}">
                                {{ substr($emp->name, 0, 1) }}
                            </div>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate {{ isset($selectedConversation) && $selectedConversation->id === $emp->id ? 'text-primary-700 dark:text-primary-300' : '' }}">
                                    {{ $emp->name }}
                                </h4>
                                <span class="text-[10px] text-gray-400">{{ $emp->updated_at ? $emp->updated_at->format('H:i') : '' }}</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate group-hover:text-gray-700 dark:group-hover:text-gray-300">
                                {{ $emp->position->name ?? 'Empleado' }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 p-6 text-center opacity-60">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-sm">No se encontraron conversaciones.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. ÁREA DE CHAT (DERECHA) -->
        <div class="flex-1 flex flex-col bg-white dark:bg-gray-800 relative z-0">
            @if($selectedConversation)
                <!-- Cabecera -->
                <div class="px-6 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-white dark:bg-gray-800 shadow-sm z-10">
                    <a href="{{ route('empleados.show', $selectedConversation->id) }}" class="flex items-center gap-4 hover:opacity-80 transition-opacity group">
                        <div class="relative">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-800 dark:to-primary-900 text-primary-700 dark:text-primary-300 flex items-center justify-center font-bold text-lg border-2 border-white dark:border-gray-700 shadow-sm">
                                {{ substr($selectedConversation->name, 0, 1) }}
                            </div>
                            <span class="absolute bottom-0 right-0 h-2.5 w-2.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                {{ $selectedConversation->name }}
                                <span class="px-2 py-0.5 rounded text-[10px] bg-gray-100 dark:bg-gray-700 text-gray-500 uppercase tracking-wide font-bold">Ticket #{{ $selectedConversation->id }}</span>
                            </h3>
                            <p class="text-xs text-primary-600 dark:text-primary-400 font-medium uppercase tracking-wider">
                                {{ $selectedConversation->department->name ?? 'General' }}
                            </p>
                        </div>
                    </a>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('empleados.show', $selectedConversation->id) }}" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-all" title="Ver Perfil">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </a>
                        <button onclick="popOutChat({{ $selectedConversation->id }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-all" title="Minimizar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Historial -->
                <div id="inbox-history" class="flex-1 overflow-y-auto p-6 space-y-6 bg-[#F0F2F5] dark:bg-gray-900 custom-scrollbar">
                    @foreach($messages as $msg)
                        <div class="flex w-full {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} group">
                            @if($msg->sender_id !== auth()->id())
                                <div class="flex-shrink-0 mr-3 self-end pb-1">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-xs font-bold text-white">
                                        {{ substr($msg->sender->name, 0, 1) }}
                                    </div>
                                </div>
                            @endif

                            <div class="max-w-[65%]">
                                @if($msg->sender_id !== auth()->id())
                                    <span class="text-[10px] text-gray-500 ml-2 mb-0.5 block">{{ $msg->sender->name }}</span>
                                @endif

                                <div class="relative px-4 py-2.5 shadow-sm text-sm leading-relaxed
                                            {{ $msg->sender_id === auth()->id() 
                                                ? 'bg-primary-600 text-white rounded-2xl rounded-br-sm' 
                                                : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-2xl rounded-bl-sm border border-gray-200 dark:border-gray-600' }}">
                                    {{ $msg->body }}
                                </div>
                                
                                <p class="text-[10px] text-gray-400 mt-1 {{ $msg->sender_id === auth()->id() ? 'text-right mr-1' : 'text-left ml-1' }}">
                                    {{ $msg->created_at->format('d M, H:i') }}
                                    @if($msg->sender_id === auth()->id())
                                        <span class="ml-1">{{ $msg->is_read ? '✓✓' : '✓' }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Input -->
                <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
                    <form action="{{ route('messages.store', $selectedConversation->id) }}" method="POST" class="flex gap-3 items-end max-w-5xl mx-auto">
                        @csrf
                        <input type="hidden" name="subject" value="Chat">
                        
                        <div class="flex-1 relative">
                            <textarea name="message" rows="1" 
                                      class="w-full bg-gray-100 dark:bg-gray-700 border-0 rounded-3xl px-5 py-3 focus:ring-2 focus:ring-primary-500 dark:text-white shadow-inner resize-none custom-scrollbar" 
                                      placeholder="Escribe una respuesta..." 
                                      required 
                                      oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                      style="max-height: 120px; min-height: 48px;"></textarea>
                        </div>

                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105 mb-1">
                            <svg class="w-6 h-6 rotate-90 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                        </button>
                    </form>
                </div>

                <script>
                    const inboxContainer = document.getElementById('inbox-history');
                    if(inboxContainer) inboxContainer.scrollTop = inboxContainer.scrollHeight;

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
                <div class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-gray-50/50 dark:bg-gray-900/50">
                    <div class="w-32 h-32 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-600 dark:text-gray-300 mb-2">Selecciona una conversación</h3>
                    <p class="text-sm max-w-xs text-center">Elige un empleado de la lista izquierda para ver el historial de tickets o iniciar un nuevo soporte.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>