<form method="POST" action="{{ route('empleados.update', $empleado->id) }}" class="p-8">
    @csrf 
    @method('PATCH')

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
                       value="{{ old('name', $empleado->name) }}" 
                       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                       placeholder="Ej: Juan Pérez"
                       required>
                @error('name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="group">
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Correo Electrónico</label>
                <input type="email" name="email" 
                       class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                       value="{{ old('email', $empleado->email) }}" 
                       placeholder="ejemplo@empresa.com"
                       required>
                @error('email') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Teléfono -->
            <div class="group">
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Teléfono</label>
                <input type="tel" name="telefono" 
                       class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                       value="{{ old('telefono', $empleado->telefono) }}"
                       maxlength="15"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       placeholder="Solo números">
            </div>

            <!-- Dirección -->
            <div class="group">
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Dirección</label>
                <input type="text" name="direccion" 
                       class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                       value="{{ old('direccion', $empleado->direccion) }}"
                       placeholder="Calle Principal #123">
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
            <!-- Fecha de Contratación -->
            <div class="group">
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Fecha de Ingreso</label>
                <input type="date" name="fecha_contratacion" 
                       class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                       value="{{ old('fecha_contratacion', $empleado->fecha_contratacion) }}">
            </div>

            <!-- DEPARTAMENTO -->
            <div class="group">
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Departamento</label>
                <select id="edit_department_id_{{ $empleado->id }}" 
                        onchange="loadPositions(this.value, 'edit_position_id_{{ $empleado->id }}')" 
                        class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500 cursor-pointer">
                    <option value="">-- Seleccionar --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ ($empleado->position && $empleado->position->department_id == $dept->id) ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- CARGO -->
            <div class="group">
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Cargo / Puesto</label>
                <select name="position_id" id="edit_position_id_{{ $empleado->id }}" 
                        class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500 cursor-pointer">
                    <option value="">-- Selecciona Dept primero --</option>
                    @if($empleado->position && $empleado->position->department)
                        @foreach($empleado->position->department->positions as $pos)
                            <option value="{{ $pos->id }}" {{ $empleado->position_id == $pos->id ? 'selected' : '' }}>
                                {{ $pos->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('position_id') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <!-- SECCIÓN 3: Seguridad (Opcional) -->
    <div class="mb-8 bg-gray-50 dark:bg-gray-700/30 p-5 rounded-xl border border-gray-100 dark:border-gray-700">
        <div class="group">
            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Nueva Contraseña <span class="text-gray-400 font-normal text-xs">(Opcional)</span>
            </label>
            <input type="password" name="password" 
                   class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-primary-500"
                   placeholder="Dejar en blanco para mantener la actual">
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
        <button @click="showEditModal = false" type="button" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-500">
            Cancelar
        </button>
        <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transform hover:scale-105 transition-all duration-200 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Guardar Cambios
        </button>
    </div>
</form>