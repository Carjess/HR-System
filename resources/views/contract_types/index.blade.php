<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tipos de Contrato') }}
        </h2>
    </x-slot>

    {{-- Inicializamos el estado del modal de creación --}}
    <div class="py-12" x-data="{ showCreateModal: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de Éxito -->
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded dark:bg-green-900 dark:text-green-300 dark:border-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-6">
                        <form method="GET" action="{{ route('tipos-contrato.index') }}" class="sm:flex sm:items-center gap-4 w-full sm:w-auto">
                            <div>
                                <label for="search" class="sr-only">Buscar</label>
                                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Buscar contrato...">
                            </div>
                            <button type="submit" class="mt-2 sm:mt-0 w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Buscar</button>
                        </form>

                        <button @click="showCreateModal = true" class="w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Añadir Nuevo Tipo
                        </button>
                    </div>

                    <!-- Lista -->
                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tipos as $tipo)
                                <div x-data="{ showEditModal: false, showDetailModal: false }" class="flex flex-wrap items-center gap-y-4 py-6">
                                    <!-- Nombre -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $tipo->name }}</dd>
                                    </dl>
                                    <!-- Dept -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departamento:</dt>
                                        <dd class="mt-1.5 text-sm text-gray-900 dark:text-white">{{ $tipo->department->name ?? 'N/A' }}</dd>
                                    </dl>
                                    <!-- Cargo -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cargo:</dt>
                                        <dd class="mt-1.5 text-sm text-gray-900 dark:text-white">{{ $tipo->position->name ?? 'General' }}</dd>
                                    </dl>
                                    <!-- Salario -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Salario Base:</dt>
                                        <dd class="mt-1.5 text-sm font-bold text-green-600 dark:text-green-400">${{ number_format($tipo->salary, 2) }}</dd>
                                    </dl>

                                    <!-- Acciones -->
                                    <div class="w-full sm:w-auto flex items-center justify-end gap-3">
                                        <button @click="showDetailModal = true" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-medium text-sm">Ver Detalles</button>
                                        <button @click="showEditModal = true" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 font-medium text-sm">Editar</button>
                                        <form method="POST" action="{{ route('tipos-contrato.destroy', $tipo->id) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 font-medium text-sm" onclick="return confirm('¿Eliminar este tipo?')">Eliminar</button>
                                        </form>
                                    </div>

                                    <!-- MODAL DETALLES -->
                                    <div x-show="showDetailModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                        <div class="relative w-full max-w-2xl h-auto" @click.away="showDetailModal = false">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-6 space-y-4">
                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Detalles del Contrato</h3>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div><p class="text-sm text-gray-500">Nombre</p><p class="font-semibold dark:text-white">{{ $tipo->name }}</p></div>
                                                    <div><p class="text-sm text-gray-500">Salario</p><p class="font-bold text-green-600">${{ number_format($tipo->salary, 2) }}</p></div>
                                                    <div><p class="text-sm text-gray-500">Departamento</p><p class="dark:text-white">{{ $tipo->department->name ?? 'N/A' }}</p></div>
                                                    <div><p class="text-sm text-gray-500">Cargo Específico</p><p class="dark:text-white">{{ $tipo->position->name ?? 'Todos' }}</p></div>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500 mb-1">Descripción</p>
                                                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded text-sm dark:text-gray-300">{{ $tipo->description ?? 'Sin descripción' }}</div>
                                                </div>
                                                <div class="flex justify-end"><button @click="showDetailModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Cerrar</button></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL EDITAR -->
                                    <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                        <div class="relative w-full max-w-2xl h-auto max-h-full overflow-y-auto" @click.away="showEditModal = false">
                                            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                <div class="flex justify-between p-4 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar: {{ $tipo->name }}</h3>
                                                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                                                </div>
                                                <form method="POST" action="{{ route('tipos-contrato.update', $tipo->id) }}" class="p-6">
                                                    @csrf @method('PATCH')
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                                        <input type="text" name="name" value="{{ old('name', $tipo->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                                            <select name="department_id" onchange="loadPositions(this.value, 'position_id_{{ $tipo->id }}')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                                <option value="">-- Seleccionar --</option>
                                                                @foreach ($departments as $dept)
                                                                    <option value="{{ $dept->id }}" {{ $tipo->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                                                            <select name="position_id" id="position_id_{{ $tipo->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salario Base ($)</label>
                                                        <input type="number" name="salary" step="0.01" value="{{ old('salary', $tipo->salary) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                                        <textarea name="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $tipo->description) }}</textarea>
                                                    </div>
                                                    <div class="flex justify-end space-x-2">
                                                        <button @click="showEditModal = false" type="button" class="text-gray-500 bg-white border border-gray-200 rounded-lg px-5 py-2.5 hover:text-gray-900">Cancelar</button>
                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-5 py-2.5">Actualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center text-gray-500 dark:text-gray-400">No hay tipos de contrato.</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="mt-6">{!! $tipos->appends($filters)->links() !!}</div>
                </div>
            </div>
        </div>

        <!-- MODAL CREAR -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-2xl h-auto max-h-full overflow-y-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between p-4 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Crear Nuevo Tipo de Contrato</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                    </div>
                    <form method="POST" action="{{ route('tipos-contrato.store') }}" class="p-6">
                        @csrf 
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                <select name="department_id" onchange="loadPositions(this.value, 'create_position_id')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                                <select name="position_id" id="create_position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" disabled>
                                    <option value="">-- Selecciona Dept --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salario Base ($)</label>
                            <input type="number" name="salary" step="0.01" value="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                            <textarea name="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button @click="showCreateModal = false" type="button" class="text-gray-500 bg-white border border-gray-200 rounded-lg px-5 py-2.5 hover:text-gray-900">Cancelar</button>
                            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 rounded-lg px-5 py-2.5">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadPositions(deptId, targetSelectId) {
            var positionSelect = document.getElementById(targetSelectId);
            positionSelect.innerHTML = '<option value="">Cargando...</option>';
            positionSelect.disabled = true;
            if (deptId) {
                fetch('/api/departamentos/' + deptId + '/cargos')
                    .then(response => response.json())
                    .then(data => {
                        positionSelect.innerHTML = '<option value="">-- General / Todos --</option>';
                        if(data.length > 0){
                            data.forEach(position => {
                                var option = document.createElement('option');
                                option.value = position.id;
                                option.text = position.name;
                                positionSelect.appendChild(option);
                            });
                            positionSelect.disabled = false;
                        } else {
                            positionSelect.innerHTML = '<option value="">No hay cargos</option>';
                        }
                    })
                    .catch(error => { positionSelect.innerHTML = '<option value="">Error</option>'; });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept --</option>';
                positionSelect.disabled = true;
            }
        }
    </script>
</x-app-layout>