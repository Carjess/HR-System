<!-- 
    SIDEBAR DE NAVEGACIÓN
    Diseño: Fondo Blanco Limpio con Acentos Verde Petróleo (#315762)
    Funcionalidad: Colapsable. Footer con MENÚ DE CONFIGURACIÓN.
-->
<aside :class="[
            sidebarOpen ? 'w-64' : 'w-20',
            isSidebarReady ? 'transition-all duration-300 ease-in-out' : ''
       ]" 
       class="flex flex-col flex-shrink-0 h-full bg-white dark:bg-gray-900 z-20 shadow-xl border-r border-gray-100 dark:border-gray-800 transition-colors duration-300"> 
    
    <!-- 1. CABECERA (LOGO Y BOTÓN) -->
    <div class="flex items-center h-20 px-4 overflow-hidden bg-white dark:bg-gray-900 transition-colors duration-300"
         :class="[
            sidebarOpen ? 'justify-between' : 'justify-center',
            isSidebarReady ? 'transition-all duration-300' : ''
         ]">
        
        <!-- Logo / Nombre -->
        <div class="flex items-center justify-center w-full" x-show="sidebarOpen" x-transition.opacity.duration.200ms>
            <a href="{{ route('dashboard') }}" class="block">
                
                <img src="{{ asset('img/rh_green.png') }}" 
                     alt="Logo HR-System" 
                     class="h-16 w-aut block dark:hidden">

                <img src="{{ asset('img/rh_white.jpg') }}" 
                     alt="Logo HR-System" 
                     class="h-16 w-auto hidden dark:block">
            </a>
        </div>

        <!-- Logo Solo (Cerrado) -->
        

        <!-- Botón Alternar -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="hidden lg:block text-gray-400 hover:text-primary-600 focus:outline-none flex-shrink-0 transition-colors p-1 rounded-md hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-primary-400"
                title="Alternar Menú">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- 2. MENÚ DE NAVEGACIÓN -->
    <div class="flex-1 flex flex-col overflow-y-auto px-3 py-6 space-y-2 custom-scrollbar">
        
        <p x-show="sidebarOpen" x-transition class="px-3 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2 mt-1">Principal</p>

        <!-- DASHBOARD -->
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Dashboard</span>
        </x-nav-link>

        <!-- MENSAJERÍA -->
        <x-nav-link :href="route('messages.inbox')" :active="request()->routeIs('messages.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Mensajería</span>
        </x-nav-link>

        <!-- CALENDARIO -->
        <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Calendario</span>
        </x-nav-link>

        @can('is-admin')
            <div x-show="sidebarOpen" class="my-4 border-t border-gray-100 dark:border-gray-800"></div>
            <p x-show="sidebarOpen" x-transition class="px-3 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Gestión</p>

            <x-nav-link :href="route('empleados.index')" :active="request()->routeIs('empleados.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Empleados</span>
            </x-nav-link>

            <x-nav-link :href="route('ausencias.index')" :active="request()->routeIs('ausencias.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Ausencias</span>
            </x-nav-link>

            <x-nav-link :href="route('payroll.index')" :active="request()->routeIs('payroll.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Nómina</span>
            </x-nav-link>

            <div x-show="sidebarOpen" class="my-4 border-t border-gray-100 dark:border-gray-800"></div>
            <p x-show="sidebarOpen" x-transition class="px-3 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Admin</p>

            <x-nav-link :href="route('departamentos.index')" :active="request()->routeIs('departamentos.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5-10v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Deptos</span>
            </x-nav-link>

            <x-nav-link :href="route('tipos-contrato.index')" :active="request()->routeIs('tipos-contrato.*')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Contratos</span>
            </x-nav-link>
        @endcan
        
        @if(auth()->user()->role === 'employee')
            <x-nav-link :href="route('empleados.show', auth()->user()->id)" :active="request()->routeIs('empleados.show')" x-bind:class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Mi Perfil</span>
            </x-nav-link>
        @endif

    </div>
    
    <!-- 3. FOOTER DEL SIDEBAR (CONFIGURACIÓN) -->
    <!-- CORRECCIÓN: El menú flotante ahora tiene clases dinámicas para posicionarse bien -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 transition-colors duration-300 relative" 
         x-data="{ configOpen: false }">
        
        <!-- MENÚ FLOTANTE DE CONFIGURACIÓN -->
        <div x-show="configOpen" 
             @click.away="configOpen = false"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             
             /* CLASE DINÁMICA: Si sidebarOpen, arriba. Si cerrado, a la derecha */
             :class="sidebarOpen ? 'bottom-full left-4 right-4 mb-2 w-auto' : 'left-full bottom-2 ml-3 w-56'"
             
             class="absolute bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50">
            
            <div class="p-2 space-y-1">
                <!-- Opción: Tema -->
                <button @click="toggleTheme()" class="w-full flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <div class="flex items-center gap-2">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Tema</span>
                    </div>
                    <span class="text-xs text-gray-400" x-text="darkMode ? 'Oscuro' : 'Claro'"></span>
                </button>

                <!-- Opción: Idioma -->
                <button class="w-full flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors opacity-50 cursor-not-allowed" title="Próximamente">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                        <span>Idioma</span>
                    </div>
                    <span class="text-xs text-gray-400">ES</span>
                </button>
            </div>
        </div>

        <!-- BOTÓN PRINCIPAL -->
        <button @click="configOpen = !configOpen" 
                class="flex items-center w-full p-2.5 rounded-xl transition-colors duration-200 group hover:bg-white dark:hover:bg-gray-800 hover:shadow-sm hover:border-gray-200 dark:hover:border-gray-700"
                :class="sidebarOpen ? '' : 'justify-center'"
                title="Configuración">
            
            <!-- BOTÓN PRINCIPAL (ENGRANAJE REAL) -->
        <button @click="configOpen = !configOpen" 
                class="flex items-center w-full p-2.5 rounded-xl transition-colors duration-200 group hover:bg-white dark:hover:bg-gray-800 hover:shadow-sm hover:border-gray-200 dark:hover:border-gray-700"
                :class="sidebarOpen ? '' : 'justify-center'"
                title="Configuración">
            
            <!-- Icono Engranaje SVG Estándar -->
            <div class="text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear w-6 h-6" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                </svg>
            </div>

            <div class="flex-1 min-w-0 text-left ml-3" x-show="sidebarOpen" x-cloak>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-primary-600 dark:group-hover:text-white transition-colors">Configuración</p>
            </div>
            
            <div class="text-gray-400" x-show="sidebarOpen" x-cloak>
                <svg class="w-4 h-4 transform transition-transform duration-200" :class="configOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
            </div>
        </button>
    </div>
</aside>