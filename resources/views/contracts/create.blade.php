<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Usamos el nombre del empleado en el título --}}
            Añadir Nuevo Contrato a: {{ $empleado->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('empleados.contratos.store', $empleado->id) }}">
                        @csrf 

                        <div class="mt-4">
                            <label for="contract_type_id">Tipo de Contrato:</label>
                            <select name="contract_type_id" id="contract_type_id" class="block w-full mt-1" required>
                                <option value="">Selecciona un tipo</option>
                                {{-- Aquí usamos la variable $tiposContrato --}}
                                @foreach ($tiposContrato as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="salary">Salario (Bruto Mensual):</label>
                            <input type="number" name="salary" id="salary" class="block w-full mt-1" min="0" step="0.01" required>
                        </div>

                        <div class="mt-4">
                            <label for="start_date">Fecha de Inicio:</label>
                            <input type="date" name="start_date" id="start_date" class="block w-full mt-1" required>
                        </div>

                        <div class="mt-4">
                            <label for="end_date">Fecha de Fin (Opcional, para contratos indefinidos dejar en blanco):</label>
                            <input type="date" name="end_date" id="end_date" class="block w-full mt-1">
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Contrato
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>