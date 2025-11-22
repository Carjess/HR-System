<form method="POST" action="{{ route('empleados.update', $empleado->id) }}" class="p-8">
    @csrf 
    @method('PATCH')

    <!-- Campo oculto para identificar el empleado -->
    <input type="hidden" name="id" value="{{ $empleado->id }}">

    <!-- 1. Datos Personales -->
    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Datos Personales</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Nombre -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nombre Completo</label>
            <input type="text" name="name" value="{{ old('name', $empleado->name) }}" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                   required 
                   oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
            
            @if($errors->has('name') && old('id') == $empleado->id) 
                <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span> 
            @endif
        </div>

        <!-- Email -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" name="email" value="{{ old('email', $empleado->email) }}" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                   required>
            
            @if($errors->has('email') && old('id') == $empleado->id) 
                <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span> 
            @endif
        </div>

        <!-- Teléfono -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Teléfono</label>
            <input type="tel" name="telefono" value="{{ old('telefono', $empleado->telefono) }}" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                   maxlength="15" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            @if($errors->has('telefono') && old('id') == $empleado->id) 
                <span class="text-red-600 text-sm">{{ $errors->first('telefono') }}</span> 
            @endif
        </div>

        <!-- Dirección -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
    </div>

    <!-- 2. Datos Laborales -->
    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Información Laboral</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Fecha Ingreso -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Fecha Ingreso</label>
            <input type="date" name="fecha_contratacion" value="{{ old('fecha_contratacion', $empleado->fecha_contratacion) }}" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- Departamento -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Departamento</label>
            <select name="department_id" 
                    onchange="loadPositions(this.value, 'position_select_{{ $empleado->id }}')" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">-- Seleccionar --</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" 
                        {{-- Prioridad: 1. Valor 'old' (si falló validación), 2. Valor actual de BD --}}
                        {{ old('department_id', $empleado->position->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Cargo -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Cargo / Puesto</label>
            <select name="position_id" id="position_select_{{ $empleado->id }}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                
                {{-- 
                   LÓGICA ROBUSTA PARA CARGAR OPCIONES:
                   Si el empleado ya tiene departamento, cargamos los cargos de ese departamento.
                   El 'selected' se encarga de marcar el correcto.
                --}}
                @php
                    $currentDeptId = old('department_id', $empleado->position->department_id ?? null);
                    // Buscamos en la colección $departments que ya tenemos disponible en la vista
                    $dept = $departments->firstWhere('id', $currentDeptId);
                    $positions = $dept ? $dept->positions : collect([]);
                @endphp

                @if($positions->isNotEmpty())
                    <option value="">-- Selecciona un Cargo --</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}" {{ old('position_id', $empleado->position_id) == $pos->id ? 'selected' : '' }}>
                            {{ $pos->name }}
                        </option>
                    @endforeach
                @else
                    <option value="">-- Selecciona Dept primero --</option>
                @endif
            </select>
            
            @if($errors->has('position_id') && old('id') == $empleado->id) 
                <span class="text-red-600 text-sm">{{ $errors->first('position_id') }}</span> 
            @endif
        </div>

        <!-- Contraseña (Opcional) -->
        <div>
            <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nueva Contraseña (Opcional)</label>
            <input type="password" name="password" placeholder="Dejar en blanco para no cambiar" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
    </div>

    <!-- Botones -->
    <div class="flex justify-end space-x-4">
        <button @click="showEditModal = false" type="button" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
            Cancelar
        </button>
        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
            Actualizar
        </button>
    </div>
</form>