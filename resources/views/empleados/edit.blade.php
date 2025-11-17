<x-app-layout>
    {{-- Encabezado --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empleado') }}
        </h2>
    </x-slot>

    {{-- Contenido --}}
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Formulario --}}
                    {{-- AÚN NO HEMOS CREADO 'empleados.store', PERO LO HAREMOS EN EL PRÓXIMO PASO --}}
                    <form method="POST" action="{{ route('empleados.update', $empleado->id) }}">
                        @csrf 
                        @method('PATCH') 
                        
                        <div>
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" class="block w-full mt-1"value="{{ $empleado->name }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="block w-full mt-1" value="{{ $empleado->email }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="password">Contraseña: (Opcional, dejar en blanco para no cambiar)</label>
                            <input type="password" name="password" id="password" class="block w-full mt-1">
                        </div>

                        <div class="mt-4">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" name="telefono" id="telefono" class="block w-full mt-1" value="{{ $empleado->telefono }}">>
                        </div>

                        <div class="mt-4">
                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccion" id="direccion" class="block w-full mt-1" value="{{ $empleado->direccion }}">>
                        </div>

                        <div class="mt-4">
                            <label for="fecha_contratacion">Fecha de Contratación:</label>
                            <input type="date" name="fecha_contratacion" id="fecha_contratacion" class="block w-full mt-1" value="{{ $empleado->fecha_contratacion }}">
                        </div>

                        <div class="mt-4">
                            <label for="position_id">Puesto:</label>
                            <select name="position_id" id="position_id" class="block w-full mt-1">
                                <option value="">Selecciona un puesto</option>
                                @foreach ($posiciones as $posicion)
                                    <option value="{{ $posicion->id }}" 
                                        {{ $empleado->position_id == $posicion->id ? 'selected' : '' }}>
                                        {{ $posicion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Empleado
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>