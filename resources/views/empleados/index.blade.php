<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Empleados') }}
        </h2>
        
        <style>
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

    <div class="" x-data="{ showCreateModal: {{ $errors->hasBag('default') && !$errors->has('id') ? 'true' : 'false' }} }">
        <div class="w-full">
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-100 text-green-800 text-base border border-green-300 rounded-xl shadow-sm dark:bg-green-900/50 dark:text-green-300 dark:border-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles Superiores -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                        <!-- Buscador y Filtros -->
                        <form method="GET" action="{{ route('empleados.index') }}" class="sm:flex sm:items-center gap-4 w-full sm:w-auto">
                            <div class="relative">
                                <input placeholder="Buscar empleado..." class="input shadow-sm hover:shadow-md focus:shadow-lg focus:border-2 border-gray-300 px-5 py-3 rounded-xl w-56 transition-all focus:w-64 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium" name="search" type="search" value="{{ $filters['search'] ?? '' }}" />
                                <svg class="size-6 absolute top-3 right-3 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                            </div>
                            <div class="w-full sm:w-64">
                                <select name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm hover:shadow-md focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-medium transition-shadow">
                                    <option value="">Todos los Departamentos</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ ($filters['department_id'] ?? '') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn-anim w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-md">Filtrar</button>
                        </form>

                        <button @click="showCreateModal = true" class="btn-anim w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 flex items-center justify-center gap-2 shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nuevo Empleado
                        </button>
                    </div>

                    <!-- TABLA DE EMPLEADOS -->
                    <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-sm text-gray-700 uppercase font-bold tracking-wider bg-gray-100 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Empleado</th>
                                    <th scope="col" class="px-6 py-4">Puesto</th>
                                    <th scope="col" class="px-6 py-4">Departamento</th>
                                    <th scope="col" class="px-6 py-4 hidden sm:table-cell">Fecha Ingreso</th>
                                    <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($empleados as $empleado)
                                    <!-- 
                                        CAMBIO CLAVE: onclick en el TR para ir al perfil.
                                        Esto hace que toda la fila sea clicable.
                                    -->
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                        onclick="window.location.href='{{ route('empleados.show', $empleado->id) }}'"
                                        x-data="{ showEditModal: {{ $errors->has('id') && old('id') == $empleado->id ? 'true' : 'false' }} }">
                                        
                                        <!-- Columna: Empleado -->
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-lg shadow-sm border border-blue-100 dark:border-blue-800">
                                                    {{ substr($empleado->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-lg font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors block leading-tight">
                                                        {{ $empleado->name }}
                                                    </div>
                                                    <div class="font-normal text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $empleado->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Columna: Puesto -->
                                        <td class="px-6 py-5 text-base text-gray-900 dark:text-white font-medium">
                                            {{ $empleado->position->name ?? 'Sin Asignar' }}
                                        </td>

                                        <!-- Columna: Departamento (BADGE CLICABLE) -->
                                        @php
                                            $deptId = $empleado->position?->department_id;
                                        @endphp
                                        <td class="px-6 py-5">
                                            @if($deptId)
                                                <!-- 
                                                    CAMBIO: 'onclick="event.stopPropagation()"' evita que el clic 
                                                    suba al TR y te lleve al perfil del empleado. En su lugar,
                                                    el enlace <a> te lleva al departamento.
                                                -->
                                                <a href="{{ route('departamentos.edit', $deptId) }}" 
                                                   onclick="event.stopPropagation()"
                                                   class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800 hover:bg-blue-100 dark:hover:bg-blue-900/50 hover:scale-105 transition-transform"
                                                   title="Administrar Departamento">
                                                    {{ $empleado->position->department->name }}
                                                </a>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                                    General
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Columna: Fecha -->
                                        <td class="px-6 py-5 hidden sm:table-cell text-base font-medium text-gray-700 dark:text-gray-300">
                                            {{ $empleado->fecha_contratacion ? \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d M, Y') : '-' }}
                                        </td>

                                        <!-- Columna: Acciones -->
                                        <td class="px-6 py-5 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <!-- Botón Editar (Con @click.stop para no disparar el TR) -->
                                                <button @click.stop="showEditModal = true" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all" title="Editar">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                
                                                <!-- Botón Eliminar (Con stopPropagation) -->
                                                <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" 
                                                            onclick="event.stopPropagation(); return confirm('¿Estás seguro de eliminar este empleado?')" 
                                                            title="Eliminar">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- MODAL EDITAR (Teleport para evitar bugs visuales) -->
                                            <template x-teleport="body">
                                                <!-- @click.stop en el contenedor para seguridad -->
                                                <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left" @click.stop="">
                                                    <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showEditModal = false">
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                            <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Editar Empleado: {{ $empleado->name }}</h3>
                                                                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                                </button>
                                                            </div>
                                                            @include('empleados.partials.edit-form', ['empleado' => $empleado])
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-lg font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                                            No se encontraron empleados que coincidan con tu búsqueda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        {!! $empleados->appends($filters)->links() !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CREAR (Reutilizamos el mismo diseño) -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Añadir Nuevo Empleado</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('empleados.store') }}" class="p-8">
                        @csrf 
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Datos Personales</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nombre Completo</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                @if($errors->has('name') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span> @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                @if($errors->has('email') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span> @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Teléfono</label>
                                <input type="tel" name="telefono" value="{{ old('telefono') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Dirección</label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Información Laboral</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Fecha Ingreso</label>
                                <input type="date" name="fecha_contratacion" value="{{ old('fecha_contratacion', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Departamento</label>
                                <select name="department_id" onchange="loadPositions(this.value, 'create_position_id')" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Cargo</label>
                                <select name="position_id" id="create_position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" disabled>
                                    <option value="">-- Selecciona Dept primero --</option>
                                </select>
                                @if($errors->has('position_id') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('position_id') }}</span> @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Contraseña</label>
                                <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                @if($errors->has('password') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('password') }}</span> @endif
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button @click="showCreateModal = false" type="button" class="text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-base px-6 py-3 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white transition-colors">Cancelar</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-base px-6 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Global -->
    <script>
        function loadPositions(deptId, targetSelectId) {
            var positionSelect = document.getElementById(targetSelectId);
            positionSelect.innerHTML = '<option value="">Cargando...</option>';
            positionSelect.disabled = true;

            if (deptId) {
                fetch('/api/departamentos/' + deptId + '/cargos')
                    .then(response => response.json())
                    .then(data => {
                        positionSelect.innerHTML = '<option value="">-- Selecciona --</option>';
                        if(data.length > 0){
                            data.forEach(position => {
                                var option = document.createElement('option');
                                option.value = position.id;
                                option.text = position.name;
                                positionSelect.appendChild(option);
                            });
                            positionSelect.disabled = false;
                        } else {
                            positionSelect.innerHTML = '<option value="">Sin cargos</option>';
                        }
                    })
                    .catch(error => {
                        positionSelect.innerHTML = '<option value="">Error</option>';
                    });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept --</option>';
                positionSelect.disabled = true;
            }
        }
    </script>
</x-app-layout>