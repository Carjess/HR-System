<x-app-layout>
    {{-- Encabezado de la Página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tipos de Contrato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de Éxito -->
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded dark:bg-green-900 dark:text-green-300 dark:border-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles: Búsqueda y Botón de Crear -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-6">
                        
                        <!-- Formulario de Búsqueda -->
                        <form method="GET" action="{{ route('tipos-contrato.index') }}" class="sm:flex sm:items-center gap-4">
                            
                            <!-- Búsqueda por Nombre -->
                            <div>
                                <label for="search" class="sr-only">Buscar</label>
                                <input type="text" name="search" id="search"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="Buscar por nombre..."
                                       value="{{ $filters['search'] ?? '' }}">
                            </div>
                            
                            <!-- Botón de Filtrar -->
                            <button type="submit" class="mt-2 sm:mt-0 w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Buscar</button>
                        </form>

                        <!-- Botón de Crear Tipo de Contrato -->
                        <a href="{{ route('tipos-contrato.create') }}" class="w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Añadir nuevo contrato
                        </a>
                    </div>

                    <!-- Lista de Tipos de Contrato (Nuevo Diseño) -->
                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            
                            @forelse ($tipos as $tipo)
                                <div class="flex flex-wrap items-center gap-y-4 py-6">
                                    
                                    <!-- Nombre -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $tipo->name }}
                                        </dd>
                                    </dl>

                                    <!-- Fecha de Creación -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Creado:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $tipo->created_at->format('d/m/Y') }}</Ddi>
                                    </dl>

                                    <!-- Botones de Acciones -->
                                    <div class="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                                        <a href="{{ route('tipos-contrato.edit', $tipo->id) }}" class="w-full inline-flex justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 lg:w-auto">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('tipos-contrato.destroy', $tipo->id) }}" class="w-full lg:w-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-lg border border-red-700 px-3 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white lg:w-auto"
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este tipo de contrato?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron tipos de contrato.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Paginación -->
                    <nav class="mt-6 flex items-center justify-center sm:mt-8" aria-label="Page navigation">
                        {{-- Esto renderiza tu nueva paginación redonda --}}
                        {!! $tipos->appends($filters)->links() !!}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>