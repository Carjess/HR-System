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

    <!-- Estilo para x-cloak y anti-parpadeo del Sidebar -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* 1. ESTADO COLAPSADO (Puro CSS instantáneo, 0ms flicker) */
        html.sidebar-collapsed #sidebar {
            width: 5rem !important; /* 80px */
        }
        html.sidebar-collapsed .sidebar-label {
            display: none !important;
        }
        html.sidebar-collapsed #sidebar .sidebar-header-box {
            justify-content: center !important;
        }
        html.sidebar-collapsed #sidebar a,
        html.sidebar-collapsed #sidebar button.sidebar-btn {
            justify-content: center !important;
        }

        /* 2. ESTADO EXPANDIDO (Ancho cómodo de 16rem / 256px o 18rem si se desea) */
        html:not(.sidebar-collapsed) #sidebar {
            width: 16rem !important; /* 256px (w-64) */
        }
        html:not(.sidebar-collapsed) #sidebar .sidebar-header-box {
            justify-content: space-between !important;
        }

        /* 3. Desactivar transiciones durante la carga de la página para evitar parpadeos */
        .preload,
        .preload * {
            transition: none !important;
        }
    </style>

    <!-- SCRIPT DE INICIALIZACIÓN TEMPRANA (Evita FOUC de Tema y Sidebar) -->
    <script>
        // 1. Tema
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // 2. Sidebar (Lectura síncrona antes del primer render)
        if (localStorage.getItem('sidebarOpen') === 'false') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300" x-data="{ 
              sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
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
    x-init="$watch('sidebarOpen', val => {
        localStorage.setItem('sidebarOpen', val);
        if (val) {
            document.documentElement.classList.remove('sidebar-collapsed');
        } else {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    })">

    <div class="flex h-screen overflow-hidden">

        <!-- 1. BARRA LATERAL -->
        @include('layouts.navigation')

        <!-- 2. ÁREA PRINCIPAL -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- HEADER SUPERIOR -->
            <header
                class="flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-800 shadow-sm z-10 sticky top-0 transition-colors duration-300">

                <!-- Botón Móvil -->
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
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
                            <button
                                class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                <div
                                    class="h-9 w-9 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ Auth::user()->role === 'admin' ? 'Administrador' : 'Empleado' }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Ver Perfil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
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

</body>

</html>