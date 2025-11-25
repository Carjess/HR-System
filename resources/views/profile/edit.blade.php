<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuración de Cuenta') }}
        </h2>
    </x-slot>

    <div class="pb-12">
        
        <!-- 1. BANNER Y TARJETA DE IDENTIDAD -->
        <div class="relative mb-10">
            <!-- Fondo Degradado (Estilo "Admin/Settings" - Tonos Grises y Azul Oscuro) -->
            <div class="h-48 w-full bg-gradient-to-r from-gray-800 to-blue-900 rounded-b-[3rem] shadow-lg absolute top-0 left-0 z-0"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center p-8 gap-8">
                        
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="h-28 w-28 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-4xl font-bold text-gray-600 dark:text-gray-300 border-4 border-white dark:border-gray-800 shadow-md">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        
                        <!-- Info Principal -->
                        <div class="text-center md:text-left flex-grow">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $user->name }}</h1>
                            <p class="text-gray-500 dark:text-gray-400 font-medium mb-3">{{ $user->email }}</p>
                            
                            <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                <!-- Badge de Rol -->
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }} dark:bg-opacity-20">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ ucfirst($user->role) }}
                                </span>
                                
                                <!-- Fecha de Registro -->
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Miembro desde {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. FORMULARIOS DE CONFIGURACIÓN -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Actualizar Información -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition hover:shadow-xl">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Información Personal</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Actualiza tus datos de contacto y dirección.</p>
                    </div>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Actualizar Contraseña -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition hover:shadow-xl">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="p-2 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg text-yellow-600 dark:text-yellow-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Seguridad</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Cambia tu contraseña para mantener tu cuenta segura.</p>
                    </div>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Borrar Cuenta -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-red-100 dark:border-red-900/30 transition hover:shadow-xl">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg text-red-600 dark:text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-red-600 dark:text-red-400">Zona de Peligro</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Eliminar tu cuenta y todos tus datos permanentemente.</p>
                    </div>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>