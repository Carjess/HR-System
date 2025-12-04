<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Departamentos') }}
        </h2>
        
        <style>
            /* Animaciones estándar */
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration { display: none; }
        </style>
    </x-slot>

    <div class="" x-data="{ showCreateModal: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="w-full">
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de Estado -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 text-base border border-emerald-300 rounded-xl shadow-sm dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles Superiores -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                        
                        <!-- Buscador -->
                        <form method="GET" action="{{ route('departamentos.index') }}" class="sm:flex sm:items-center gap-4 w-full sm:w-auto">
                            <div class="relative w-full sm:w-96">
                                <input placeholder="Buscar departamento..." 
                                       class="input shadow-sm hover:shadow-md focus:shadow-lg focus:ring-2 focus:ring-primary-500 border-gray-300 px-5 py-3 rounded-xl w-full transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium text-base" 
                                       name="search" 
                                       type="search" 
                                       value="{{ $filters['search'] ?? '' }}" />
                                <svg class="size-6 absolute top-3.5 right-4 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                            </div>
                            <button type="submit" class="btn-anim w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-md transition-colors">
                                Buscar
                            </button>
                        </form>

                        <!-- Botón Crear (AHORA NARANJA) -->
                        <button @click="showCreateModal = true" class="btn-anim w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800 flex items-center justify-center gap-2 shadow-md transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nuevo Departamento
                        </button>
                    </div>

                    <!-- TABLA DE DEPARTAMENTOS -->
                    <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <!-- Header Verde Petróleo -->
                            <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-90">
                                <tr>
                                    <th scope="col" class="px-6 py-4 pl-8">Nombre del Departamento</th>
                                    <th scope="col" class="px-6 py-4 hidden sm:table-cell">Fecha Creación</th>
                                    <th scope="col" class="px-6 py-4 hidden md:table-cell">Cargos</th>
                                    <th scope="col" class="px-6 py-4">Personal</th>
                                    <th scope="col" class="px-6 py-4 text-right pr-8">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($departments as $department)
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors"
                                        onclick="window.location.href='{{ route('departamentos.edit', $department->id) }}'">
                                        
                                        <!-- Nombre -->
                                        <td class="px-6 py-6 pl-8 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-300 border border-primary-100 dark:border-primary-800">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5-10v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                                                </div>
                                                <div class="text-lg font-bold text-gray-900 dark:text-white block leading-tight">
                                                    {{ $department->name }}
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Fecha Creación -->
                                        <td class="px-6 py-6 hidden sm:table-cell text-base text-gray-600 dark:text-gray-300 font-medium">
                                            {{ $department->created_at->format('d M, Y') }}
                                        </td>

                                        <!-- Cargos -->
                                        <td class="px-6 py-6 hidden md:table-cell">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                                {{ $department->positions_count }} Puestos
                                            </span>
                                        </td>

                                        <!-- Personal -->
                                        <td class="px-6 py-6">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                                {{ $department->positions->flatMap->users->count() }} Empleados
                                            </span>
                                        </td>

                                        <!-- Acciones -->
                                        <td class="px-6 py-6 text-right pr-8">
                                            <div class="flex items-center justify-end gap-3">
                                                <!-- Editar / Gestionar -->
                                                <button onclick="event.stopPropagation(); window.location.href='{{ route('departamentos.edit', $department->id) }}'"
                                                   class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-gray-700 transition-all" 
                                                   title="Gestionar Cargos y Editar">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                
                                                <!-- Eliminar -->
                                                <form method="POST" action="{{ route('departamentos.destroy', $department->id) }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="event.stopPropagation(); return confirm('¿Estás seguro de eliminar este departamento?')"
                                                            class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" 
                                                            title="Eliminar">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-xl font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                                            No se encontraron departamentos registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-10">
                        {{ $departments->appends($filters)->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CREAR DEPARTAMENTO (Diseño Premium) -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-md h-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    
                    <!-- Cabecera -->
                    <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Crear Nuevo Departamento</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('departamentos.store') }}" class="p-8">
                        @csrf 

                        <div class="mb-8 group">
                            <label for="name" class="block mb-3 text-base font-bold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Nombre del Departamento</label>
                            <input type="text" name="name" id="name" 
                                   class="block w-full p-4 text-lg bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500" 
                                   value="{{ old('name') }}" 
                                   required autofocus 
                                   placeholder="Ej. Marketing, Finanzas...">
                            @error('name')
                                <span class="text-red-600 text-sm mt-2 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <button @click="showCreateModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                Cancelar
                            </button>
                            <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transform hover:scale-105 transition-all duration-200 dark:bg-primary-600 dark:hover:bg-primary-700">
                                Guardar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>