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

        <!-- 
            SOLUCIÓN AL PARPADEO: Estilo para x-cloak.
            Oculta los elementos hasta que Alpine esté listo.
        -->
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    
    <!-- 
      LÓGICA DE PERSISTENCIA Y ANTI-PARPADEO:
      1. x-data: Inicializa 'sidebarOpen' leyendo del localStorage.
      2. isSidebarReady: Empieza en false para evitar animaciones al cargar.
      3. x-init: 
         - Observa cambios en sidebarOpen para guardarlos.
         - Espera 300ms para poner isSidebarReady en true (activando las animaciones).
    -->
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" 
          x-data="{ 
              sidebarOpen: localStorage.getItem('sidebarOpen') ? localStorage.getItem('sidebarOpen') === 'true' : true,
              isSidebarReady: false
          }"
          x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val)); setTimeout(() => isSidebarReady = true, 300)">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- 1. BARRA LATERAL -->
            <!-- Se incluye desde navigation.blade.php y reaccionará a la variable sidebarOpen -->
            @include('layouts.navigation')

            <!-- 2. ÁREA PRINCIPAL (Derecha) -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <!-- HEADER SUPERIOR -->
                <header class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm z-10">
                    
                    <!-- Botón Móvil (Solo visible en pantallas pequeñas para abrir el menú) -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    
                    <!-- Título de la Página (Opcional) -->
                    <div class="flex-1 ml-4 text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ $header ?? '' }}
                    </div>

                    <!-- Perfil de Usuario -->
                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <!-- Avatar Circular con Inicial -->
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Info del Usuario -->
                                <div class="px-4 py-2 border-b dark:border-gray-600">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Empleado' }}</p>
                                </div>

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Ver Perfil') }}
                                </x-dropdown-link>

                                <!-- Cerrar Sesión -->
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

                <!-- CONTENIDO DE LA PÁGINA -->
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
                
            </div>
        </div>
    </body>
</html>