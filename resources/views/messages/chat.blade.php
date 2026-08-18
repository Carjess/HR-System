<!-- 
    COMPONENTE: Widget de Chat Flotante (Autónomo y Persistente)
    Ubicación: resources/views/messages/chat.blade.php
-->

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .no-transition { transition: none !important; }
    .snap-animation { transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }

    /* Estilo Burbuja */
    .floating-orb {
        background-color: #2563eb; 
        box-shadow: inset 0 4px 10px rgba(255,255,255,0.4), inset 0 -5px 10px rgba(0,0,0,0.3), 0 10px 20px rgba(0,0,0,0.3);
        border: 2px solid rgba(255,255,255,0.2);
    }
    .floating-orb:hover {
        background-color: #1d4ed8;
        transform: scale(1.08);
    }
</style>

@if(auth()->id() !== $empleado->id)

<script>
function floatingChatWidget() {
    return {
        isOpen: true,
        isMinimized: false,
        isDragging: false,
        hasMoved: false,
        x: 0,
        y: 0,
        startX: 0,
        startY: 0,
        messageBody: '',

        init() {
            const storedMin = localStorage.getItem('chat_minimized');
            this.isMinimized = storedMin === 'true';

            const storedX = localStorage.getItem('chat_pos_x');
            const storedY = localStorage.getItem('chat_pos_y');

            const winW = window.innerWidth;
            const winH = window.innerHeight;
            const widgetW = this.isMinimized ? 64 : 384;
            const widgetH = this.isMinimized ? 64 : 480;

            if (storedX !== null && storedY !== null && !isNaN(parseInt(storedX)) && !isNaN(parseInt(storedY))) {
                this.x = parseInt(storedX);
                this.y = parseInt(storedY);
            } else {
                this.x = Math.max(10, winW - widgetW - 24);
                this.y = Math.max(10, winH - widgetH - 24);
            }

            this.snapToEdge();
            this.$nextTick(() => this.scrollToBottom());

            window.addEventListener('resize', () => this.snapToEdge());
        },

        scrollToBottom() {
            setTimeout(() => {
                const container = document.getElementById('chat-history');
                if (container) container.scrollTop = container.scrollHeight;
            }, 50);
        },

        startDrag(e) {
            this.isDragging = true;
            this.hasMoved = false;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            this.startX = clientX - this.x;
            this.startY = clientY - this.y;

            const moveHandler = (evt) => {
                if (!this.isDragging) return;
                const curX = evt.touches ? evt.touches[0].clientX : evt.clientX;
                const curY = evt.touches ? evt.touches[0].clientY : evt.clientY;
                if (Math.abs(curX - this.startX - this.x) > 4 || Math.abs(curY - this.startY - this.y) > 4) {
                    this.hasMoved = true;
                }
                this.x = curX - this.startX;
                this.y = curY - this.startY;
            };

            const stopHandler = () => {
                this.isDragging = false;
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', stopHandler);
                document.removeEventListener('touchmove', moveHandler);
                document.removeEventListener('touchend', stopHandler);
                this.snapToEdge();
            };

            document.addEventListener(e.touches ? 'touchmove' : 'mousemove', moveHandler, { passive: false });
            document.addEventListener(e.touches ? 'touchend' : 'mouseup', stopHandler);
        },

        snapToEdge() {
            const screenW = window.innerWidth;
            const screenH = window.innerHeight;
            const widgetW = this.isMinimized ? 64 : Math.min(384, screenW - 20);
            const widgetH = this.isMinimized ? 64 : 480;

            if (this.y < 10) this.y = 10;
            if (this.y > screenH - widgetH - 10) this.y = Math.max(10, screenH - widgetH - 10);

            if (this.isMinimized) {
                const midPoint = screenW / 2;
                if (this.x + (widgetW / 2) < midPoint) {
                    this.x = 10;
                } else {
                    this.x = Math.max(10, screenW - widgetW - 10);
                }
            } else {
                if (this.x < 10) this.x = 10;
                if (this.x + widgetW > screenW - 10) this.x = Math.max(10, screenW - widgetW - 10);
            }

            localStorage.setItem('chat_pos_x', this.x);
            localStorage.setItem('chat_pos_y', this.y);
        },

        toggleMinimize() {
            this.isMinimized = !this.isMinimized;
            localStorage.setItem('chat_minimized', this.isMinimized ? 'true' : 'false');
            this.$nextTick(() => {
                this.snapToEdge();
                if (!this.isMinimized) {
                    this.scrollToBottom();
                }
            });
        },

        handleOrbClick() {
            if (!this.hasMoved) {
                this.toggleMinimize();
            }
        },

        closeGlobalChat() {
            this.isOpen = false;
            localStorage.removeItem('chat_minimized');

            fetch('{{ route('chat.close') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                keepalive: true
            }).catch(e => console.error('Error al cerrar chat:', e));
        },

        async sendMessage() {
            if (!this.messageBody.trim()) return;

            const text = this.messageBody;
            this.messageBody = '';

            const history = document.getElementById('chat-history');
            const msgDiv = document.createElement('div');
            msgDiv.className = 'flex w-full justify-end';
            msgDiv.innerHTML = `
                <div class='max-w-[85%] bg-blue-600 text-white rounded-l-lg rounded-tr-lg p-2.5 text-sm shadow-sm break-words'>
                    <p>${text.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</p>
                    <p class='text-[10px] mt-1 opacity-70 text-right'>Ahora</p>
                </div>`;
            history.appendChild(msgDiv);
            this.scrollToBottom();

            try {
                await fetch('{{ route('messages.store', $empleado->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: text })
                });
            } catch (e) {
                console.error('Error enviando mensaje:', e);
            }
        }
    };
}
</script>

<div x-data="floatingChatWidget()" 
     x-show="isOpen" 
     x-cloak
     :style="`top: ${y}px; left: ${x}px; touch-action: none;`"
     class="fixed z-50 snap-animation"
     :class="{ 'no-transition': isDragging }"
     style="display: none;">
    
    <!-- 1. BOLA FLOTANTE (MINIMIZADO) -->
    <div x-show="isMinimized" 
         @mousedown="startDrag"
         @touchstart="startDrag"
         @click="handleOrbClick"
         class="floating-orb w-16 h-16 rounded-full text-white flex items-center justify-center cursor-move relative select-none z-50 transition-all">
        
        <div class="font-bold text-xl pointer-events-none drop-shadow-md">{{ substr($empleado->name, 0, 1) }}</div>
        <span class="absolute bottom-1 right-1 block h-3.5 w-3.5 rounded-full bg-green-400 border-2 border-white pointer-events-none shadow-sm"></span>
        
        <button @click.stop="closeGlobalChat" 
                class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md border border-white hover:bg-red-600 z-50 transition-colors"
                title="Cerrar chat">✕</button>
    </div>

    <!-- 2. VENTANA DE CHAT (EXPANDIDO) -->
    <div x-show="!isMinimized" class="w-80 md:w-96 bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col shadow-2xl">
        
        <!-- Cabecera Azul -->
        <div @mousedown="startDrag" @touchstart="startDrag" class="bg-blue-600 p-3 flex justify-between items-center cursor-move text-white select-none relative overflow-hidden">
            <div class="flex items-center gap-2 pointer-events-none relative z-10">
                <div class="w-2.5 h-2.5 rounded-full bg-green-400 shadow-sm animate-pulse"></div>
                <span class="font-bold text-sm drop-shadow-sm">{{ $empleado->name }}</span>
            </div>
            
            <div class="flex items-center gap-2 relative z-10">
                <button @click.stop="toggleMinimize" class="hover:bg-blue-500 p-1.5 rounded transition-colors" title="Minimizar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                </button>
                <button @click.stop="closeGlobalChat" class="hover:bg-red-500 p-1.5 rounded transition-colors" title="Cerrar conversación">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Historial de mensajes -->
        <div id="chat-history" class="h-80 overflow-y-auto p-4 bg-gray-50 dark:bg-gray-900 space-y-3 scrollbar-hide">
            @foreach($messages as $msg)
                <div class="flex w-full {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] {{ $msg->sender_id === auth()->id() ? 'bg-blue-600 text-white rounded-l-lg rounded-tr-lg' : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-r-lg rounded-tl-lg border border-gray-200 dark:border-gray-600' }} p-2.5 text-sm shadow-sm break-words">
                        <p>{{ $msg->body }}</p>
                        <p class="text-[10px] mt-1 opacity-70 text-right">{{ $msg->created_at->format('H:i') }}</p>
                    </div>
                </div>
            @endforeach
            
            @if($messages->isEmpty()) 
                <p class="text-center text-xs text-gray-400 italic mt-10">Inicia la conversación...</p> 
            @endif
        </div>

        <!-- Input -->
        <div class="p-3 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <form @submit.prevent="sendMessage" class="flex gap-2">
                <input type="text" x-model="messageBody" class="flex-1 bg-gray-100 dark:bg-gray-700 border-0 rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 dark:text-white" placeholder="Escribe un mensaje..." required autocomplete="off">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-md transition-colors flex-shrink-0" title="Enviar">
                    <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endif