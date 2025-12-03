<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Empleado: ') . $empleado->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('empleados.update', $empleado->id) }}">
                        @csrf 
                        @method('PATCH')

                        <!-- 1. Información Personal -->
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">Datos Personales</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Nombre -->
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Completo</label>
                                <input type="text" name="name" id="name" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                       value="{{ old('name', $empleado->name) }}" 
                                       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                                       required>
                                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('email', $empleado->email) }}" required>
                                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                                <input type="tel" name="telefono" id="telefono" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                       value="{{ old('telefono', $empleado->telefono) }}"
                                       maxlength="15"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('telefono') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Dirección -->
                            <div>
                                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('direccion', $empleado->direccion) }}">
                            </div>
                        </div>

                        <!-- 2. Información Laboral -->
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">Información Laboral</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Fecha de Contratación -->
                            <div>
                                <label for="fecha_contratacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Ingreso</label>
                                <input type="date" name="fecha_contratacion" id="fecha_contratacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('fecha_contratacion', $empleado->fecha_contratacion) }}">
                            </div>

                            <!-- SELECT DEPARTAMENTO -->
                            <div>
                                <label for="department_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                <select id="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">-- Selecciona un Departamento --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ $currentDepartmentId == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- SELECT CARGO -->
                            <div>
                                <label for="position_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo / Puesto</label>
                                <select name="position_id" id="position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" {{ $currentDepartmentId ? '' : 'disabled' }}>
                                    <option value="">-- Selecciona un Cargo --</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ old('position_id', $empleado->position_id) == $position->id ? 'selected' : '' }}>
                                            {{ $position->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Seguridad -->
                        <div class="mb-6">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Dejar en blanco para mantener la actual">
                            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('empleados.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mr-4 flex items-center">Cancelar</a>
                            <button type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 transition-colors">
                                Actualizar Empleado
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Mismo script de carga dinámica de cargos
        document.getElementById('department_id').addEventListener('change', function() {
            var departmentId = this.value;
            var positionSelect = document.getElementById('position_id');
            positionSelect.innerHTML = '<option value="">Cargando...</option>';
            positionSelect.disabled = true;

            if (departmentId) {
                fetch('/api/departamentos/' + departmentId + '/cargos')
                    .then(response => response.json())
                    .then(data => {
                        positionSelect.innerHTML = '<option value="">-- Selecciona un Cargo --</option>';
                        if(data.length > 0){
                            data.forEach(position => {
                                var option = document.createElement('option');
                                option.value = position.id; option.text = position.name; positionSelect.appendChild(option);
                            });
                            positionSelect.disabled = false;
                        } else { positionSelect.innerHTML = '<option value="">No hay cargos</option>'; }
                    });
            } else {
                positionSelect.innerHTML = '<option value="">-- Primero selecciona un Departamento --</option>';
                positionSelect.disabled = true;
            }
        });
    </script>
</x-app-layout>