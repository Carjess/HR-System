<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Administrar Departamento
        </h2>
        
        <style>
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }
            
            .row-card { transition: all 200ms ease-in-out; }
            .row-card:hover { background-color: #f8fafc; transform: scale-[1.005]; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); z-index: 10; position: relative; }
            .dark .row-card:hover { background-color: #374151; }
        </style>
    </x-slot>

    <div class="w-full p-6 space-y-8">
        
        <!-- Mensajes de Éxito -->
        @if (session('status'))
            <div class="p-4 bg-emerald-100 text-emerald-800 text-base border border-emerald-300 rounded-xl shadow-sm dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('status') }}
            </div>
        @endif

        <!-- SECCIÓN SUPERIOR: GRID DE 2 COLUMNAS -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- COLUMNA 1: FORMULARIO DE EDICIÓN (Ocupa 2 espacios) -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-100 dark:border-gray-700 h-full">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        
                        <div class="flex items-center gap-4 mb-8">
                            <div class="p-3 bg-primary-50 dark:bg-primary-900/30 rounded-2xl text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5-10v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Configuración</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Edita la información base del departamento.</p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('departamentos.update', $departamento->id) }}">
                            @csrf 
                            @method('PATCH')
    
                            <div class="space-y-6">
                                <div class="group">
                                    <label for="name" class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2 group-hover:text-primary-600 transition-colors">Nombre del Departamento</label>
                                    <div class="relative">
                                        <input type="text" name="name" id="name" 
                                               class="block w-full p-4 pl-12 text-lg bg-gray-50 border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:bg-white hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 font-bold tracking-wide" 
                                               value="{{ old('name', $departamento->name) }}" required>
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    </div>
                                    @error('name') <span class="text-red-600 text-sm font-medium mt-1">{{ $message }}</span> @enderror
                                </div>
    
                                <div class="flex justify-end pt-2">
                                    <button type="submit" class="btn-anim bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-primary-500/20 transition-colors flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- COLUMNA 2: RESUMEN / WIDGET (Ocupa 1 espacio) -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-primary-700 to-primary-900 rounded-2xl shadow-xl h-full text-white p-8 relative overflow-hidden">
                    
                    <!-- Decoración de fondo -->
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-primary-400 opacity-20 rounded-full blur-xl"></div>

                    <h3 class="text-lg font-bold mb-6 relative z-10 flex items-center gap-2 opacity-90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Resumen del Área
                    </h3>

                    <div class="space-y-6 relative z-10">
                        
                        <!-- Estadística 1: Total Empleados (CON EFECTO HOVER) -->
                        <!-- Añadido: hover:scale-105 hover:bg-white/20 transition-all cursor-default -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl backdrop-blur-sm border border-white/10 transition-all duration-300 ease-out hover:scale-105 hover:bg-white/20 hover:shadow-lg cursor-default group">
                            <div class="p-3 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-3xl font-bold group-hover:scale-110 origin-left transition-transform">{{ $departamento->positions->flatMap->users->count() }}</p>
                                <p class="text-xs text-primary-100 uppercase tracking-wider font-semibold">Colaboradores</p>
                            </div>
                        </div>

                        <!-- Estadística 2: Total Cargos (CON EFECTO HOVER) -->
                        <!-- Añadido: hover:scale-105 hover:bg-white/20 transition-all cursor-default -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl backdrop-blur-sm border border-white/10 transition-all duration-300 ease-out hover:scale-105 hover:bg-white/20 hover:shadow-lg cursor-default group">
                            <div class="p-3 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-3xl font-bold group-hover:scale-110 origin-left transition-transform">{{ $departamento->positions->count() }}</p>
                                <p class="text-xs text-primary-100 uppercase tracking-wider font-semibold">Cargos Definidos</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 text-center">
                        <p class="text-xs text-primary-200 font-medium">
                            Departamento creado el {{ $departamento->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- SECCIÓN 3: Gestión de Cargos (Positions) -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-100 dark:border-gray-700" x-data="{ showCreateModal: false }">
            <div class="p-8 text-gray-900 dark:text-gray-100">
                
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Cargos Asignados</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gestiona los puestos laborales dentro de este departamento.</p>
                        </div>
                    </div>
                    <!-- Botón Naranja -->
                    <button @click="showCreateModal = true" class="btn-anim bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-xl flex items-center gap-2 transition-colors shadow-md text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Añadir Cargo
                    </button>
                </div>

                <!-- TABLA DE CARGOS -->
                <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <table class="w-full text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-white uppercase bg-primary-600 dark:bg-primary-900/50 font-bold tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4 pl-8">Nombre del Cargo</th>
                                <th scope="col" class="px-6 py-4">Empleados Activos</th>
                                <th scope="col" class="px-6 py-4 text-right pr-8">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($departamento->positions as $position)
                                <tr class="bg-white dark:bg-gray-800 row-card transition-colors" x-data="{ showEditModal: false }">
                                    <td class="px-6 py-5 pl-8 whitespace-nowrap">
                                        <div class="text-base font-bold text-gray-900 dark:text-white">{{ $position->name }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                            {{ $position->users->count() }} Empleados
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right pr-8">
                                        <div class="flex items-center justify-end gap-3">
                                            <button @click="showEditModal = true" class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2 rounded-full hover:bg-primary-50 dark:hover:bg-gray-700 transition-all" title="Editar Cargo">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <form method="POST" action="{{ route('puestos.destroy', $position->id) }}" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" onclick="return confirm('¿Eliminar este cargo?')" title="Eliminar Cargo">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- MODAL EDITAR CARGO -->
                                        <template x-teleport="body">
                                            <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4 md:inset-0 h-full text-left transition-opacity duration-300" @click="showEditModal = false">
                                                <div class="relative w-full max-w-md h-auto" @click.stop>
                                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700 overflow-hidden">
                                                        <div class="flex justify-between p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-900/80">
                                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Editar Cargo</h3>
                                                            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            </button>
                                                        </div>
                                                        <form method="POST" action="{{ route('puestos.update', $position->id) }}" class="p-8">
                                                            @csrf @method('PATCH')
                                                            <div class="mb-8 group">
                                                                <label class="block mb-3 text-base font-bold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Nombre del Cargo</label>
                                                                <input type="text" name="name" value="{{ $position->name }}" class="block w-full p-4 text-lg bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500" required>
                                                            </div>
                                                            <input type="hidden" name="department_id" value="{{ $departamento->id }}">
                                                            <div class="flex justify-end gap-3">
                                                                <button @click="showEditModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">Cancelar</button>
                                                                <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transform hover:scale-105 transition-all duration-200 dark:bg-primary-600 dark:hover:bg-primary-700">Actualizar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-16 text-center text-lg text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">No hay cargos definidos para este departamento aún.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ==================== MODAL PARA AÑADIR CARGO ==================== -->
            <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                <div class="relative w-full max-w-md h-auto" @click.away="showCreateModal = false">
                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="flex justify-between p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Nuevo Cargo en {{ $departamento->name }}</h3>
                            <button @click="showCreateModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm p-2 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('puestos.store') }}" class="p-8">
                            @csrf
                            <div class="mb-8 group">
                                <label for="position_name" class="block mb-3 text-base font-bold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Nombre del Cargo</label>
                                <input type="text" name="name" id="position_name" class="block w-full p-4 text-lg bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500" placeholder="Ej. Analista, Supervisor..." required>
                            </div>
                            <input type="hidden" name="department_id" value="{{ $departamento->id }}">
                            <div class="flex justify-end gap-3">
                                <button @click="showCreateModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">Cancelar</button>
                                <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transform hover:scale-105 transition-all duration-200 dark:bg-primary-600 dark:hover:bg-primary-700">Guardar Cargo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>