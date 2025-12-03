<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tipos de Contrato') }}
        </h2>
        
        <style>
            /* Animaciones globales */
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            /* Ocultar decoraciones de búsqueda en Webkit */
            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration { display: none; }
        </style>
    </x-slot>

    {{-- Inicializamos el estado del modal de creación --}}
    <div class="" x-data="{ showCreateModal: {{ $errors->hasBag('default') && !$errors->has('id') ? 'true' : 'false' }} }">
        <div class="w-full">
            <!-- Contenedor transparente -->
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('status'))
                        <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 text-base border border-emerald-300 rounded-xl shadow-sm dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles Superiores -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                        
                        <!-- Buscador Moderno -->
                        <form method="GET" action="{{ route('tipos-contrato.index') }}" class="sm:flex sm:items-center gap-4 w-full sm:w-auto">
                            <div class="relative w-full sm:w-96">
                                <input placeholder="Buscar contrato..." 
                                       class="input shadow-sm hover:shadow-md focus:shadow-lg focus:ring-2 focus:ring-primary-500 border-gray-300 px-5 py-3 rounded-xl w-full transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium text-base" 
                                       name="search" 
                                       type="search" 
                                       value="{{ $filters['search'] ?? '' }}" />
                                <svg class="size-6 absolute top-3.5 right-4 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                            </div>
                            <button type="submit" class="hidden sm:block btn-anim text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-semibold rounded-xl text-base px-6 py-3 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 shadow-md transition-colors">
                                Buscar
                            </button>
                        </form>

                        <!-- Botón Crear: Naranja (Solicitado) -->
                        <button @click="showCreateModal = true" class="btn-anim w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800 flex items-center justify-center gap-2 shadow-md transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nuevo Tipo
                        </button>
                    </div>

                    <!-- TABLA DE TIPOS DE CONTRATO (Estilo Premium) -->
                    <div class="overflow-hidden rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700"> 
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <!-- HEADER OSCURO (PRIMARY) -->
                            <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-900/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 pl-8 rounded-tl-lg">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Departamento</th>
                                    <th scope="col" class="px-6 py-4">Cargo</th>
                                    <th scope="col" class="px-6 py-4">Salario Base</th>
                                    <th scope="col" class="px-6 py-4 text-right pr-8 rounded-tr-lg">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($tipos as $tipo)
                                    <!-- Fila Interactiva: Clic abre el modal de EDITAR -->
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                        x-data="{ showEditModal: {{ $errors->has('id') && old('id') == $tipo->id ? 'true' : 'false' }} }"
                                        @click="showEditModal = true">
                                        
                                        <!-- Nombre -->
                                        <td class="px-6 py-6 pl-8 whitespace-nowrap text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">
                                            {{ $tipo->name }}
                                        </td>

                                        <!-- Departamento -->
                                        <td class="px-6 py-6">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                                {{ $tipo->department->name ?? 'General' }}
                                            </span>
                                        </td>

                                        <!-- Cargo -->
                                        <td class="px-6 py-6">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-purple-50 text-purple-700 border border-purple-100 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800">
                                                {{ $tipo->position->name ?? 'Todos' }}
                                            </span>
                                        </td>

                                        <!-- Salario -->
                                        <td class="px-6 py-6 text-base font-bold text-emerald-600 dark:text-emerald-400">
                                            ${{ number_format($tipo->salary, 2) }}
                                        </td>

                                        <!-- Acciones -->
                                        <td class="px-6 py-6 text-right pr-8">
                                            <div class="flex items-center justify-end gap-3">
                                                <!-- Botón Editar (Solo Icono) -->
                                                <button @click.stop="showEditModal = true" class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2 rounded-full hover:bg-primary-50 dark:hover:bg-gray-700 transition-all" title="Editar">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                
                                                <!-- Botón Eliminar -->
                                                <form method="POST" action="{{ route('tipos-contrato.destroy', $tipo->id) }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="event.stopPropagation(); return confirm('¿Eliminar este tipo de contrato?')" 
                                                            class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" 
                                                            title="Eliminar">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- ======================================================= -->
                                            <!-- MODAL EDITAR (ESTILO CLONADO DE EMPLEADOS) -->
                                            <!-- ======================================================= -->
                                            <template x-teleport="body">
                                                <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left" @click="showEditModal = false">
                                                    
                                                    <!-- Contenedor del modal con estilo similar a empleados -->
                                                    <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.stop="">
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
                                                            
                                                            <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Editar Tipo: {{ $tipo->name }}</h3>
                                                                <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                                </button>
                                                            </div>

                                                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                                                <form method="POST" action="{{ route('tipos-contrato.update', $tipo->id) }}">
                                                                    @csrf @method('PATCH')
                                                                    <input type="hidden" name="id" value="{{ $tipo->id }}">

                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                                                        <!-- Nombre (span-2) -->
                                                                        <div class="col-span-1 md:col-span-2">
                                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Puesto / Contrato</label>
                                                                            <input type="text" name="name" value="{{ old('name', $tipo->name) }}" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                                            @if($errors->has('name') && old('id') == $tipo->id) <span class="text-red-600 text-sm mt-1 font-medium">{{ $errors->first('name') }}</span> @endif
                                                                        </div>

                                                                        <!-- Departamento -->
                                                                        <div>
                                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                                                            <select name="department_id" onchange="loadPositions(this.value, 'position_id_{{ $tipo->id }}')" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer">
                                                                                <option value="">-- Seleccionar --</option>
                                                                                @foreach ($departments as $dept)
                                                                                    <option value="{{ $dept->id }}" {{ $tipo->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <!-- Cargo -->
                                                                        <div>
                                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                                                                            <select name="position_id" id="position_id_{{ $tipo->id }}" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" @if(!$tipo->department) disabled @endif>
                                                                                @if($tipo->department)
                                                                                    <option value="">-- General / Todos --</option>
                                                                                    @foreach($tipo->department->positions as $pos)
                                                                                        <option value="{{ $pos->id }}" {{ $tipo->position_id == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                                                                                    @endforeach
                                                                                @else
                                                                                    <option value="">-- Selecciona Dept --</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>

                                                                        <!-- Salario -->
                                                                        <div>
                                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salario Base ($)</label>
                                                                            <input type="number" name="salary" step="0.01" value="{{ old('salary', $tipo->salary) }}" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                                        </div>
                                                                    </div>

                                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-t pt-6 dark:border-gray-700">Detalles Adicionales</h3>

                                                                    <div class="mb-6">
                                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción (Opcional)</label>
                                                                        <textarea name="description" rows="3" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $tipo->description) }}</textarea>
                                                                    </div>

                                                                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                                                                        <button type="button" @click="showEditModal = false" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">Cancelar</button>
                                                                        <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg">Actualizar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-xl font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                                            No se encontraron tipos de contrato.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-10">
                        {!! $tipos->appends($filters)->links() !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CREAR (ESTILO CLONADO DE EMPLEADOS) -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    
                    <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Crear Nuevo Tipo de Contrato</h3>
                        <button type="button" @click="showCreateModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="POST" action="{{ route('tipos-contrato.store') }}">
                            @csrf 
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Puesto / Contrato</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required autofocus>
                                    @error('name') <span class="text-red-600 text-sm mt-2 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                    <select name="department_id" id="create_department_id" onchange="loadPositions(this.value, 'create_position_id')" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                                    <select name="position_id" id="create_position_id" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer" disabled>
                                        <option value="">-- Selecciona Dept --</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salario Base ($)</label>
                                    <input type="number" name="salary" step="0.01" value="{{ old('salary', 0) }}" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                </div>
                            </div>

                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-t pt-6 dark:border-gray-700">Detalles Adicionales</h3>

                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                <textarea name="description" rows="3" class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
                            </div>

                            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                                <button type="button" @click="showCreateModal = false" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">Cancelar</button>
                                <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT DE CARGA DINÁMICA (MEJORADO PARA PERSISTENCIA COMO EMPLEADOS) -->
    <script>
        // Función mejorada para cargar cargos y soportar el valor 'old' si existe
        function loadPositions(deptId, targetSelectId, oldPositionId = null) {
            var positionSelect = document.getElementById(targetSelectId);
            if (!positionSelect) return;
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
                                // Seleccionar si coincide con oldPositionId
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
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept --</option>';
                positionSelect.disabled = true;
            }
        }

        // EVENTO PARA RECARGAR DATOS SI HAY ERROR DE VALIDACIÓN
        document.addEventListener('DOMContentLoaded', function() {
            // Persistencia para modal crear
            var oldDeptCreate = "{{ old('department_id') }}";
            var oldPosCreate = "{{ old('position_id') }}";
            if (oldDeptCreate) {
                loadPositions(oldDeptCreate, 'create_position_id', oldPosCreate);
            }

            // Persistencia para modal editar (si la validación falló en edición)
            var oldEditId = "{{ old('id') }}";
            var oldDeptEdit = "{{ old('department_id') }}";
            var oldPosEdit = "{{ old('position_id') }}";
            if (oldEditId) {
                // Cargar los cargos del departamento correspondiente en el select del tipo específico
                loadPositions(oldDeptEdit, 'position_id_' + oldEditId, oldPosEdit);
            }
        });
    </script>
</x-app-layout>