<!-- 
    COMPONENTE: Widget de Chat Flotante Global (Estilo Messenger)
    Ubicación: resources/views/messages/chat.blade.php
    Descripción: Estructura visual del chat. La lógica JS reside ahora en app.blade.php.
-->

<style>
    /* Ocultar scrollbar pero permitir scroll */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Clase para desactivar animaciones mientras se arrastra (para que siga al mouse al instante) */
    .no-transition { transition: none !important; }

    /* Curva de animación suave para el efecto de "imán" al soltar */
    .snap-animation { transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }

    /* ================= ESTILO DE LA BOLA (LIMPIO CON SOMBRA 3D) ================= */
    .floating-orb {
        background-color: #2563eb; /* Azul base */
        
        /* Efecto 3D: Luces internas y sombras externas */
        box-shadow: 
            inset 0 4px 10px rgba(255,255,255,0.4), /* Brillo superior */
            inset 0 -5px 10px rgba(0,0,0,0.3),      /* Sombra inferior */
            0 10px 20px rgba(0,0,0,0.3);            /* Sombra proyectada en el piso */
            
        border: 2px solid rgba(255,255,255,0.2); /* Borde sutil */
    }
    
    /* Efecto al pasar el mouse (Hover) */
    .floating-orb:hover {
        background-color: #1d4ed8; /* Azul más oscuro */
        box-shadow: 
            inset 0 4px 15px rgba(255,255,255,0.5),
            inset 0 -5px 10px rgba(0,0,0,0.4),
            0 15px 30px rgba(0,0,0,0.4);
        transform: scale(1.1); /* Crece ligeramente */
    }
</style>

<!-- Verificamos que no sea el propio usuario para no chatear consigo mismo -->
@if(auth()->id() !== $empleado->id)

<!-- 
    x-data="chatWidget()" inicializa la lógica de AlpineJS.
    La función chatWidget() debe estar definida en el layout global (app.blade.php).
-->
<div x-data="chatWidget()" 
     x-init="init()"
     x-show="isOpen" 
     x-cloak
     :style="`top: ${y}px; left: ${x}px;`"
     class="fixed z-50 snap-animation"
     :class="{ 'no-transition': isDragging }"
     style="display: none;"> <!-- style="display:none" evita parpadeos antes de cargar -->
    
    <!-- 1. BOLA FLOTANTE (MINIMIZADO) -->
    <div x-show="isMinimized" 
         @mousedown.prevent="startDrag"
         @touchstart.prevent="startDrag"
         @click="handleClick"
         class="floating-orb w-16 h-16 rounded-full text-white flex items-center justify-center cursor-move relative select-none z-50 transition-transform">
        
        <!-- Iniciales del usuario -->
        <div class="font-bold text-xl pointer-events-none drop-shadow-md">{{ substr($empleado->name, 0, 1) }}</div>
        
        <!-- Punto verde de "En línea" -->
        <span class="absolute bottom-1 right-1 block h-3.5 w-3.5 rounded-full bg-green-400 border-2 border-white pointer-events-none shadow-sm"></span>
        
        <!-- Botón X para CERRAR completamente el chat -->
        <button @click.stop="closeGlobalChat" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md border border-white hover:bg-red-600 z-50 transition-colors" title="Cerrar chat">✕</button>
    </div>

    <!-- 2. VENTANA DE CHAT (EXPANDIDO) -->
    <div x-show="!isMinimized" class="w-80 md:w-96 bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col shadow-2xl">
        
        <!-- Cabecera Azul (Zona segura para arrastrar la ventana) -->
        <div @mousedown.prevent="startDrag" @touchstart.prevent="startDrag" class="bg-blue-600 p-3 flex justify-between items-center cursor-move text-white select-none relative overflow-hidden">
            
            <!-- Info del usuario (Nombre + Estado) -->
            <div class="flex items-center gap-2 pointer-events-none relative z-10">
                <div class="w-2 h-2 rounded-full bg-green-400 shadow-sm"></div>
                <span class="font-bold text-sm drop-shadow-sm">{{ $empleado->name }}</span>
            </div>
            
            <!-- Controles de ventana -->
            <div class="flex items-center gap-2 relative z-10">
                <!-- Botón Minimizar (_) -->
                <button @click.stop="minimize" class="hover:bg-blue-500 p-1 rounded transition-colors" title="Minimizar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                </button>
                <!-- Botón Cerrar (X) -->
                <button @click.stop="closeGlobalChat" class="hover:bg-red-500 p-1 rounded transition-colors" title="Cerrar conversación">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Área de Historial de Mensajes -->
        <div id="chat-history" class="h-80 overflow-y-auto p-4 bg-gray-50 dark:bg-gray-900 space-y-3 scrollbar-hide">
            @foreach($messages as $msg)
                <!-- Lógica para alinear mensajes (Derecha: Míos / Izquierda: Otros) -->
                <div class="flex w-full {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] {{ $msg->sender_id === auth()->id() ? 'bg-blue-600 text-white rounded-l-lg rounded-tr-lg' : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-r-lg rounded-tl-lg border border-gray-200 dark:border-gray-600' }} p-2.5 text-sm shadow-sm break-words">
                        <p>{{ $msg->body }}</p>
                        <p class="text-[10px] mt-1 opacity-70 text-right">{{ $msg->created_at->format('H:i') }}</p>
                    </div>
                </div>
            @endforeach
            
            <!-- Mensaje si está vacío -->
            @if($messages->isEmpty()) 
                <p class="text-center text-xs text-gray-400 italic mt-10">Inicia la conversación...</p> 
            @endif
        </div>

        <!-- Área de Input (Escribir mensaje) -->
        <div class="p-3 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <form action="{{ route('messages.store', $empleado->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="subject" value="Chat">
                
                <!-- Campo de texto -->
                <input type="text" name="message" class="flex-1 bg-gray-100 dark:bg-gray-700 border-0 rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 dark:text-white" placeholder="Escribe..." required autocomplete="off">
                
                <!-- Botón Enviar (Flecha) -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-md transition-colors flex-shrink-0">
                    <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endif