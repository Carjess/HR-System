<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Administrar Departamento: {{ $departamento->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de Éxito -->
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <!-- SECCIÓN 1: Editar Nombre del Departamento -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Datos del Departamento</h3>
                    
                    <form method="POST" action="{{ route('departamentos.update', $departamento->id) }}">
                        @csrf 
                        @method('PATCH')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" name="name" id="name" 
                                   class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                   value="{{ old('name', $departamento->name) }}" required>
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SECCIÓN 2: Gestión de Cargos (Positions) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ showCreateModal: false }">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Cargos / Puestos en este Departamento</h3>
                        <!-- Botón para abrir el Modal de CREAR -->
                        <button @click="showCreateModal = true" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Cargo
                        </button>
                    </div>

                    <!-- Lista de Cargos -->
                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($departamento->positions as $position)
                                {{-- Cada fila tiene su propio estado para el modal de edición --}}
                                <div x-data="{ showEditModal: false }" class="flex flex-wrap items-center gap-y-4 py-4 group hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg px-2 transition-colors">
                                    
                                    <!-- Nombre del Cargo -->
                                    <div class="w-1/2 sm:w-auto flex-1">
                                        <p class="text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $position->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $position->users->count() }} Empleados activos
                                        </p>
                                    </div>

                                    <!-- Acciones -->
                                    <div class="w-auto flex items-center justify-end gap-3">
                                        <!-- Botón Editar (Abre Modal) -->
                                        <button @click="showEditModal = true" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 font-medium text-sm">
                                            Editar
                                        </button>

                                        <!-- Eliminar -->
                                        <form method="POST" action="{{ route('puestos.destroy', $position->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 font-medium text-sm"
                                                    onclick="return confirm('¿Eliminar este cargo? Si hay empleados con este cargo, quedarán huérfanos.')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>

                                    <!-- ==================== MODAL EDITAR CARGO ==================== -->
                                    <div x-show="showEditModal" 
                                         style="display: none;"
                                         x-cloak
                                         class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                        
                                        <div class="relative w-full max-w-md h-auto" @click.away="showEditModal = false">
                                            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                <div class="flex justify-between p-4 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar Cargo</h3>
                                                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                                                </div>
                                                <form method="POST" action="{{ route('puestos.update', $position->id) }}" class="p-6">
                                                    @csrf @method('PATCH')
                                                    
                                                    <!-- Nombre -->
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Cargo</label>
                                                        <input type="text" name="name" value="{{ $position->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                    </div>

                                                    <!-- Departamento Oculto (Se mantiene el mismo) -->
                                                    <input type="hidden" name="department_id" value="{{ $departamento->id }}">

                                                    <div class="flex justify-end space-x-2">
                                                        <button @click="showEditModal = false" type="button" class="text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 rounded-lg px-5 py-2.5 text-sm font-medium">Cancelar</button>
                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-5 py-2.5 text-sm font-medium">Actualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ==================== FIN MODAL EDITAR ==================== -->

                                </div>
                            @empty
                                <div class="py-8 text-center text-gray-500 dark:text-gray-400 italic">
                                    No hay cargos definidos para este departamento aún.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- ==================== MODAL CREAR CARGO ==================== -->
                <div x-show="showCreateModal" 
                     style="display: none;"
                     x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                    
                    <div class="relative w-full max-w-md h-auto" @click.away="showCreateModal = false">
                        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            
                            <!-- Cabecera -->
                            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Nuevo Cargo en {{ $departamento->name }}
                                </h3>
                                <button @click="showCreateModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>

                            <!-- Formulario -->
                            <form method="POST" action="{{ route('puestos.store') }}">
                                @csrf
                                <div class="p-6 space-y-4">
                                    
                                    <!-- Nombre del Cargo -->
                                    <div>
                                        <label for="position_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Cargo</label>
                                        <input type="text" name="name" id="position_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ej. Analista, Supervisor..." required>
                                    </div>

                                    <!-- Campo Oculto: ID del Departamento -->
                                    <input type="hidden" name="department_id" value="{{ $departamento->id }}">

                                </div>

                                <!-- Pie -->
                                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button @click="showCreateModal = false" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Cancelar</button>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar Cargo</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- ==================== FIN MODAL CREAR ==================== -->

            </div>

        </div>
    </div>
</x-app-layout>