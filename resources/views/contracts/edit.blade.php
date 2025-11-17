<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Título --}}
            Editar Contrato (Empleado: {{ $contract->employee->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('contratos.update', $contract->id) }}">
                        @csrf 
                        @method('PATCH') {{-- <-- ¡Importante para actualizar! --}}

                        <div class="mt-4">
                            <label for="contract_type_id">Tipo de Contrato:</label>
                            <select name="contract_type_id" id="contract_type_id" class="block w-full mt-1" required>
                                <option value="">Selecciona un tipo</option>
                                @foreach ($tiposContrato as $tipo)
                                    <option value="{{ $tipo->id }}" 
                                        {{-- Esto selecciona el tipo actual --}}
                                        {{ $contract->contract_type_id == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="salary">Salario (Bruto Mensual):</label>
                            {{-- Rellenamos el valor actual --}}
                            <input type="number" name="salary" id="salary" class="block w-full mt-1" min="0" step="0.01" value="{{ $contract->salary }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="start_date">Fecha de Inicio:</label>
                            {{-- Rellenamos el valor actual --}}
                            <input type="date" name="start_date" id="start_date" class="block w-full mt-1" value="{{ $contract->start_date }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="end_date">Fecha de Fin (Opcional):</label>
                            {{-- Rellenamos el valor actual --}}
                            <input type="date" name="end_date" id="end_date" class="block w-full mt-1" value="{{ $contract->end_date }}">
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Contrato
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>