<x-app-layout>
    {{-- Encabezado de la Página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Empleados') }}
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

                    <!-- Controles: Búsqueda, Filtro y Botón de Crear -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-6">
                        
                        <!-- Formulario de Búsqueda y Filtro -->
                        <form method="GET" action="{{ route('empleados.index') }}" class="sm:flex sm:items-center gap-4">
                            
                            <!-- Búsqueda por Nombre/Email -->
                            <div>
                                <label for="search" class="sr-only">Buscar</label>
                                <input type="text" name="search" id="search"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="Buscar por nombre"
                                       value="{{ $filters['search'] ?? '' }}">
                            </div>

                            <!-- Filtro por Departamento -->
                            <div>
                                <label for="department_id" class="sr-only">Filtrar por Departamento</label>
                                {{-- ESTA ES LA LÍNEA CORREGIDA: Se añadió 'sm:min-w-56' --}}
                                <select name="department_id" id="department_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:min-w-56 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Todos los Departamentos</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ ($filters['department_id'] ?? '') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Botón de Filtrar -->
                            <button type="submit" class="mt-2 sm:mt-0 w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Filtrar</button>
                        </form>

                        <!-- Botón de Crear Empleado -->
                        <a href="{{ route('empleados.create') }}" class="w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Añadir Nuevo Empleado
                        </a>
                    </div>

                    <!-- Lista de Empleados (Nuevo Diseño) -->
                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            
                            @forelse ($empleados as $empleado)
                                <div class="flex flex-wrap items-center gap-y-4 py-6">
                                    
                                    <!-- Nombre -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('empleados.show', $empleado->id) }}" class="hover:underline text-blue-500">{{ $empleado->name }}</a>
                                        </dd>
                                    </dl>

                                    <!-- Email -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $empleado->email }}</dd>
                                    </dl>

                                    <!-- Puesto -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Puesto:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $empleado->position->name ?? 'N/A' }}</dd>
                                    </dl>

                                    <!-- Departamento -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departamento:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $empleado->position->department->name ?? 'N/A' }}</dd>
                                    </dl>

                                    <!-- Botones de Acciones -->
                                    <div class="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="w-full inline-flex justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 lg:w-auto">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" class="w-full lg:w-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-lg border border-red-700 px-3 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white lg:w-auto"
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar a este empleado?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron empleados que coincidan con tu búsqueda.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Paginación -->
                    <nav class="mt-6 flex items-center justify-center sm:mt-8" aria-label="Page navigation">
                        {{-- Esto renderiza los enlaces de paginación con el estilo de Tailwind --}}
                        {{-- appends($filters) se asegura de que la paginación funcione CON los filtros --}}
                        {!! $empleados->appends($filters)->links() !!}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>