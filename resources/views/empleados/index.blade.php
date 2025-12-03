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
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #ffffff; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration { display: none; }
        </style>
    </x-slot>

    {{-- 
        Lógica del Modal: Se abre si hay errores generales (hasBag 'default') Y NO son errores de edición (has 'id').
        Esto evita que se abra el modal de crear cuando el error ocurrió en un modal de editar.
    --}}
    <div class="" x-data="{ showCreateModal: {{ $errors->any() && !$errors->has('id') ? 'true' : 'false' }} }">
        <div class="w-full">
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('status'))
                        <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 text-base border border-emerald-300 rounded-xl shadow-sm dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles Superiores -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                        <!-- Buscador y Filtros -->
                        <form method="GET" action="{{ route('empleados.index') }}" class="sm:flex sm:items-center gap-4 w-full sm:w-auto">
                            <div class="relative">
                                <input placeholder="Buscar empleado..." class="input shadow-sm hover:shadow-md focus:shadow-lg focus:ring-2 focus:ring-primary-500 border-gray-300 px-5 py-3 rounded-xl w-56 transition-all focus:w-64 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium" name="search" type="search" value="{{ $filters['search'] ?? '' }}" />
                                <svg class="size-6 absolute top-3 right-3 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                            </div>
                            <div class="w-full sm:w-64">
                                <select name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm hover:shadow-md focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-medium transition-shadow">
                                    <option value="">Todos los Departamentos</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ ($filters['department_id'] ?? '') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- BOTÓN FILTRAR: AZUL -->
                            <button type="submit" class="btn-anim w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-md transition-colors">
                                Filtrar
                            </button>
                        </form>

                        <!-- BOTÓN NUEVO EMPLEADO: NARANJA -->
                        <button @click="showCreateModal = true" class="btn-anim w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800 flex items-center justify-center gap-2 shadow-md transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nuevo Empleado
                        </button>
                    </div>

                    <!-- TABLA DE EMPLEADOS -->
                    <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <!-- HEADER VERDE PETRÓLEO -->
                            <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-900/50">
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
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                        onclick="window.location.href='{{ route('empleados.show', $empleado->id) }}'"
                                        x-data="{ showEditModal: {{ $errors->has('id') && old('id') == $empleado->id ? 'true' : 'false' }} }">
                                        
                                        <!-- Columna: Empleado -->
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-300 font-bold text-lg shadow-sm border border-primary-100 dark:border-primary-800">
                                                    {{ substr($empleado->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-lg font-bold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors block leading-tight">
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

                                        <!-- Columna: Departamento -->
                                        @php $deptId = $empleado->position?->department_id; @endphp
                                        <td class="px-6 py-5">
                                            @if($deptId)
                                                <a href="{{ route('departamentos.edit', $deptId) }}" 
                                                   onclick="event.stopPropagation()"
                                                   class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-primary-50 text-primary-700 border border-primary-100 dark:bg-primary-900/30 dark:text-primary-300 dark:border-primary-800 hover:bg-primary-100 dark:hover:bg-primary-900/50 hover:scale-105 transition-transform"
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
                                                <button @click.stop="showEditModal = true" class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2 rounded-full hover:bg-white dark:hover:bg-gray-700 transition-all" title="Editar">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                
                                                <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-white dark:hover:bg-gray-700 transition-all" 
                                                            onclick="event.stopPropagation(); return confirm('¿Estás seguro de eliminar este empleado?')" 
                                                            title="Eliminar">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- VENTANA MODAL DE EDICIÓN -->
                                            <template x-teleport="body">
                                                <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left" @click="showEditModal = false">
                                                    <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.stop>
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
                                            No se encontraron empleados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {!! $empleados->appends($filters)->links() !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CREAR EMPLEADO (CORREGIDO PARA PERSISTENCIA) -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Añadir Nuevo Empleado</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    
                    <form method="POST" action="{{ route('empleados.store') }}" class="p-8">
                        @csrf 
                        
                        <!-- SECCIÓN 1: Datos Personales -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                                <span class="w-1 h-6 bg-primary-500 rounded-full"></span>
                                Datos Personales
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nombre -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Nombre Completo</label>
                                    <input type="text" name="name" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('name') }}" 
                                           oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                                           required>
                                    @error('name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                                </div>

                                <!-- Email -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Correo Electrónico</label>
                                    <input type="email" name="email" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                                </div>

                                <!-- Teléfono -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Teléfono</label>
                                    <input type="tel" name="telefono" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('telefono') }}"
                                           maxlength="15"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>

                                <!-- Dirección -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Dirección</label>
                                    <input type="text" name="direccion" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('direccion') }}">
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: Información Laboral -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                                <span class="w-1 h-6 bg-primary-500 rounded-full"></span>
                                Información Laboral
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Fecha -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Fecha de Ingreso</label>
                                    <input type="date" name="fecha_contratacion" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('fecha_contratacion', date('Y-m-d')) }}">
                                </div>

                                <!-- DEPARTAMENTO -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Departamento</label>
                                    <!-- CORREGIDO: Agregar ID para el script y recuperar valor OLD -->
                                    <select name="department_id" id="create_department_id" 
                                            onchange="loadPositions(this.value, 'create_position_id')" 
                                            class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500 cursor-pointer">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- CARGO -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Cargo / Puesto</label>
                                    <select name="position_id" id="create_position_id" 
                                            class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500 cursor-pointer" disabled>
                                        <option value="">-- Selecciona Dept primero --</option>
                                    </select>
                                    @error('position_id') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Contraseña Inicial</label>
                                    <input type="password" name="password" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                                           required>
                                    @error('password') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Footer Botones -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <button @click="showCreateModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                Cancelar
                            </button>
                            <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transform hover:scale-105 transition-all duration-200 dark:bg-primary-600 dark:hover:bg-primary-700">
                                Registrar Empleado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT DE CARGA DINÁMICA (CON PERSISTENCIA) -->
    <script>
        // Función mejorada para cargar cargos y soportar el valor 'old' si existe
        function loadPositions(deptId, targetSelectId, oldPositionId = null) {
            var positionSelect = document.getElementById(targetSelectId);
            positionSelect.innerHTML = '<option value="">Cargando...</option>';
            positionSelect.disabled = true;

            if (deptId) {
                // Usamos una URL absoluta construida por Blade para evitar errores de ruta relativa
                var url = "{{ url('/api/departamentos') }}/" + deptId + "/cargos";
                
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la red');
                        return response.json();
                    })
                    .then(data => {
                        positionSelect.innerHTML = '<option value="">-- Selecciona --</option>';
                        if(data.length > 0){
                            data.forEach(position => {
                                var option = document.createElement('option');
                                option.value = position.id;
                                option.text = position.name;
                                // Si tenemos un valor previo (por error de validación), lo seleccionamos
                                if (oldPositionId && position.id == oldPositionId) {
                                    option.selected = true;
                                }
                                positionSelect.appendChild(option);
                            });
                            positionSelect.disabled = false;
                        } else {
                            positionSelect.innerHTML = '<option value="">No hay cargos</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching positions:', error);
                        positionSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept primero --</option>';
                positionSelect.disabled = true;
            }
        }

        // EVENTO PARA RECARGAR DATOS SI HAY ERROR DE VALIDACIÓN
        // Si la página recarga por un error, y ya había un departamento seleccionado, cargamos los cargos automáticamente.
        document.addEventListener('DOMContentLoaded', function() {
            var oldDeptId = "{{ old('department_id') }}";
            var oldPosId = "{{ old('position_id') }}";
            
            if (oldDeptId) {
                loadPositions(oldDeptId, 'create_position_id', oldPosId);
            }
        });
    </script>
</x-app-layout>