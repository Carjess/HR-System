<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Administrar Departamento: {{ $departamento->name }}
        </h2>
    </x-slot>

    <div class="w-full p-6 space-y-8">
        
        <!-- Mensajes de Éxito -->
        @if (session('status'))
            <div class="p-4 bg-green-100 text-green-800 text-base border border-green-300 rounded-xl shadow-sm dark:bg-green-900/50 dark:text-green-300 dark:border-green-800">
                {{ session('status') }}
            </div>
        @endif

        <!-- SECCIÓN 1: Editar Nombre del Departamento -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-8 text-gray-900 dark:text-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5-10v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold">Datos del Departamento</h3>
                </div>
                
                <form method="POST" action="{{ route('departamentos.update', $departamento->id) }}">
                    @csrf 
                    @method('PATCH')

                    <div class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="flex-grow w-full">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Nombre</label>
                            <input type="text" name="name" id="name" 
                                   class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-xl shadow-sm p-3 text-lg" 
                                   value="{{ old('name', $departamento->name) }}" required>
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-md">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SECCIÓN 2: Gestión de Cargos (Positions) -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700" x-data="{ showCreateModal: false }">
            <div class="p-8 text-gray-900 dark:text-gray-100">
                
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg text-purple-600 dark:text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold">Cargos Asignados</h3>
                    </div>
                    <!-- Botón Crear (Animado) -->
                    <button @click="showCreateModal = true" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl flex items-center gap-2 transition-colors shadow-md text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Añadir Cargo
                    </button>
                </div>

                <!-- TABLA DE CARGOS (Diseño Moderno) -->
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-100 dark:bg-gray-700/50 dark:text-gray-300 font-bold tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nombre del Cargo</th>
                                <th scope="col" class="px-6 py-4">Empleados Activos</th>
                                <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($departamento->positions as $position)
                                <tr class="bg-white dark:bg-gray-800 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700" x-data="{ showEditModal: false }">
                                    
                                    <!-- Nombre -->
                                    <td class="px-6 py-5 whitespace-nowrap text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $position->name }}
                                    </td>

                                    <!-- Empleados -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                            {{ $position->users->count() }}
                                        </span>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Botón Editar -->
                                            <button @click="showEditModal = true" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all" title="Editar Cargo">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <form method="POST" action="{{ route('puestos.destroy', $position->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all"
                                                        onclick="return confirm('¿Eliminar este cargo?')" title="Eliminar Cargo">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- ==================== MODAL EDITAR CARGO (TELEPORT) ==================== -->
                                        <template x-teleport="body">
                                            <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                                <div class="relative w-full max-w-md h-auto" @click.away="showEditModal = false">
                                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                        <div class="flex justify-between p-5 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Editar Cargo</h3>
                                                            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            </button>
                                                        </div>
                                                        <form method="POST" action="{{ route('puestos.update', $position->id) }}" class="p-6">
                                                            @csrf @method('PATCH')
                                                            
                                                            <div class="mb-6">
                                                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nombre del Cargo</label>
                                                                <input type="text" name="name" value="{{ $position->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm" required>
                                                            </div>

                                                            <input type="hidden" name="department_id" value="{{ $departamento->id }}">

                                                            <div class="flex justify-end space-x-3">
                                                                <button @click="showEditModal = false" type="button" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-base px-6 py-2.5 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Cancelar</button>
                                                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-base px-6 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">Actualizar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-lg text-gray-500 dark:text-gray-400 italic">
                                        No hay cargos definidos para este departamento aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ==================== MODAL PARA AÑADIR CARGO ==================== -->
            <div x-show="showCreateModal" 
                 style="display: none;"
                 x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                
                <div class="relative w-full max-w-md h-auto" @click.away="showCreateModal = false">
                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        
                        <!-- Cabecera -->
                        <div class="flex items-center justify-between p-5 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Nuevo Cargo en {{ $departamento->name }}
                            </h3>
                            <button @click="showCreateModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>

                        <!-- Formulario -->
                        <form method="POST" action="{{ route('puestos.store') }}" class="p-8">
                            @csrf
                            <div class="mb-6">
                                <label for="position_name" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nombre del Cargo</label>
                                <input type="text" name="name" id="position_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm" placeholder="Ej. Analista, Supervisor..." required>
                            </div>

                            <input type="hidden" name="department_id" value="{{ $departamento->id }}">

                            <div class="flex justify-end space-x-3">
                                <button @click="showCreateModal = false" type="button" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-base px-6 py-2.5 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Cancelar</button>
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-base px-6 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">Guardar Cargo</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- ==================== FIN MODAL ==================== -->

        </div>
    </div>
</x-app-layout>