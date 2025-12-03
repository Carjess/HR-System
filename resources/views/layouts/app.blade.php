<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Estilo para x-cloak -->
        <style> [x-cloak] { display: none !important; } </style>

        <!-- SCRIPT DE INICIALIZACIÓN DEL MODO OSCURO (Evita FOUC - Flash of Unstyled Content) -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    
    <!-- 
        Agregamos la lógica de 'darkMode' y 'toggleTheme' al x-data global 
    -->
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300" 
          x-data="{ 
              sidebarOpen: localStorage.getItem('sidebarOpen') ? localStorage.getItem('sidebarOpen') === 'true' : true,
              isSidebarReady: false,
              darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
              toggleTheme() {
                  this.darkMode = !this.darkMode;
                  if (this.darkMode) {
                      document.documentElement.classList.add('dark');
                      localStorage.setItem('theme', 'dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                      localStorage.setItem('theme', 'light');
                  }
              }
          }"
          x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val)); setTimeout(() => isSidebarReady = true, 300)">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- 1. BARRA LATERAL -->
            @include('layouts.navigation')

            <!-- 2. ÁREA PRINCIPAL -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <!-- HEADER SUPERIOR -->
                <header class="flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-800 shadow-sm z-10 sticky top-0 transition-colors duration-300">
                    
                    <!-- Botón Móvil -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    
                    <!-- Título -->
                    <div class="flex-1 ml-4 text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ $header ?? '' }}
                    </div>

                    <!-- Perfil (Dropdown) -->
                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div class="h-9 w-9 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b dark:border-gray-600">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Empleado' }}</p>
                                </div>

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Ver Perfil') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- CONTENIDO -->
                <main class="flex-1 p-4">
                    {{ $slot }}
                </main>
                
            </div>
        </div>

        <!-- === CHAT GLOBAL === -->
         @if(isset($globalChatUser) && !request()->routeIs('messages.inbox'))
            @include('messages.chat', ['empleado' => $globalChatUser, 'messages' => $globalChatMessages])
        @endif

        <!-- SCRIPT DEL CHAT WIDGET -->
        <script>
            function chatWidget() {
                return {
                    isOpen: true, 
                    isMinimized: false,
                    isDragging: false, 
                    hasMoved: false,
                    x: 0, y: 0, 
                    startX: 0, startY: 0,
                    
                    init() {
                        const storedMin = localStorage.getItem('chat_minimized');
                        const storedX = localStorage.getItem('chat_pos_x');
                        const storedY = localStorage.getItem('chat_pos_y');

                        this.isMinimized = storedMin === 'true';

                        if (storedX && storedY) {
                            this.x = parseInt(storedX);
                            this.y = parseInt(storedY);
                        } else {
                            this.x = window.innerWidth - 80; 
                            this.y = window.innerHeight - 100;
                        }
                        
                        this.snapToEdge();
                        this.scrollToBottom();

                        this.$watch('isMinimized', (val) => {
                            localStorage.setItem('chat_minimized', val);
                        });
                    },

                    closeGlobalChat() {
                        this.isOpen = false;
                        setTimeout(() => {
                            const el = this.$el;
                            if (el && el.parentNode) el.parentNode.removeChild(el);
                        }, 300);

                        fetch("{{ route('chat.close') }}", {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
                        });
                    },

                    minimize() {
                        this.isMinimized = true;
                        setTimeout(() => this.snapToEdge(), 50);
                    },

                    handleClick() {
                        if (!this.hasMoved) {
                            this.isMinimized = false;
                            setTimeout(() => this.scrollToBottom(), 100);
                        }
                    },

                    scrollToBottom() {
                        setTimeout(() => { 
                            const c = document.getElementById('chat-history'); 
                            if(c) c.scrollTop = c.scrollHeight; 
                        }, 100);
                    },

                    startDrag(e) {
                        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                        this.isDragging = false; 
                        this.hasMoved = false; 
                        this.startX = clientX - this.x;
                        this.startY = clientY - this.y;
                        const move = (e) => this.onMove(e);
                        const stop = () => this.onStop(move, stop);
                        document.addEventListener('mousemove', move);
                        document.addEventListener('touchmove', move);
                        document.addEventListener('mouseup', stop);
                        document.addEventListener('touchend', stop);
                    },

                    onMove(e) {
                        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                        if (Math.abs(clientX - this.startX - this.x) > 5 || Math.abs(clientY - this.startY - this.y) > 5) {
                            this.hasMoved = true;
                            this.isDragging = true; 
                        }
                        if (this.isDragging) {
                            this.x = clientX - this.startX;
                            this.y = clientY - this.startY;
                        }
                    },

                    onStop(moveFn, stopFn) {
                        document.removeEventListener('mousemove', moveFn);
                        document.removeEventListener('touchmove', moveFn);
                        document.removeEventListener('mouseup', stopFn);
                        document.removeEventListener('touchend', stopFn);
                        this.isDragging = false;
                        setTimeout(() => { this.snapToEdge(); }, 20);
                    },

                    snapToEdge() {
                        const screenW = window.innerWidth;
                        const screenH = window.innerHeight;
                        const widgetW = this.isMinimized ? 64 : 384; 
                        const widgetH = this.isMinimized ? 64 : 500;
                        if (this.y < 10) this.y = 10;
                        if (this.y > screenH - widgetH - 10) this.y = screenH - widgetH - 10;
                        if (this.isMinimized) {
                            const midPoint = screenW / 2;
                            if (this.x + (widgetW/2) < midPoint) this.x = 10; 
                            else this.x = screenW - widgetW - 10; 
                        } else {
                            if (this.x < 10) this.x = 10;
                            if (this.x + widgetW > screenW) this.x = screenW - widgetW - 10;
                        }
                        localStorage.setItem('chat_pos_x', this.x);
                        localStorage.setItem('chat_pos_y', this.y);
                    }
                }
            }
        </script>
        
    </body>
</html>