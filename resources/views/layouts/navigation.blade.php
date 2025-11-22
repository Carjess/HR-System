<aside :class="[
            sidebarOpen ? 'w-64' : 'w-20',
            isSidebarReady ? 'transition-all duration-300 ease-in-out' : ''
       ]" 
       class="flex flex-col flex-shrink-0 h-full bg-white dark:bg-gray-800 z-20 shadow-lg"> 
       <!-- CORRECCIÓN: Eliminado 'border-r border-gray-200 dark:border-gray-700' para quitar la línea vertical -->
    
    <!-- 1. CABECERA (LOGO Y BOTÓN) -->
    <!-- Sin borde inferior -->
    <div class="flex items-center h-16 px-4 overflow-hidden"
         :class="[
            sidebarOpen ? 'justify-between' : 'justify-center',
            isSidebarReady ? 'transition-all duration-300' : ''
         ]">
        
        <!-- Logo / Nombre -->
        <div class="flex items-center gap-3 min-w-0" x-show="sidebarOpen" x-cloak>
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-8 w-auto fill-current text-blue-600" />
                </a>
            </div>
            <span class="text-xl font-bold text-gray-800 dark:text-gray-200 whitespace-nowrap">
                HR-System
            </span>
        </div>

        <!-- Botón para Colapsar -->
        <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-500 hover:text-gray-700 focus:outline-none flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- 2. MENÚ DE NAVEGACIÓN -->
    <div class="flex-1 flex flex-col overflow-y-auto px-3 py-4 space-y-2">
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-200' }}"
           :class="sidebarOpen ? '' : 'justify-center'">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap transition-opacity duration-200">Dashboard</span>
        </a>

        <!-- SECCIÓN ADMIN -->
        @can('is-admin')
            <a href="{{ route('empleados.index') }}" 
               class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('empleados.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Empleados</span>
            </a>

            <a href="{{ route('departamentos.index') }}" 
               class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('departamentos.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5-10v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Departamentos</span>
            </a>

            <a href="{{ route('tipos-contrato.index') }}" 
               class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('tipos-contrato.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Tipos de Contrato</span>
            </a>

            <a href="{{ route('payroll.index') }}" 
               class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('payroll.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Nómina</span>
            </a>

            <a href="{{ route('ausencias.index') }}" 
               class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('ausencias.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Ausencias</span>
            </a>
        @endcan
        
        <!-- SECCIÓN EMPLEADO -->
        @if(auth()->user()->role === 'employee')
            <a href="{{ route('empleados.show', auth()->user()->id) }}" 
               class="flex items-center p-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('empleados.show') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center'">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium whitespace-nowrap">Mi Perfil</span>
            </a>
        @endif

    </div>
    
    <!-- 3. FOOTER DEL SIDEBAR -->
    <div class="p-4">
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center w-full text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
           :class="sidebarOpen ? '' : 'justify-center'">
             <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
             <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm font-medium whitespace-nowrap transition-opacity duration-200">
                 Configuración
             </span>
        </a>
    </div>
</aside>