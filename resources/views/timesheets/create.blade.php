<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Horas para: {{ $empleado->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('timesheets.store', $empleado->id) }}">
                        @csrf 

                        < class="mt-4">
                            <label for="date">Fecha:</label>
                            <input type="date" name="date" id="date" class="block w-full mt-1" value="{{ old('date') }}" required>
                            @error('date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            
                        </div>

                        <div class="mt-4">
                            <label for="hours_worked">Horas Trabajadas:</label>
                            <input type="number" name="hours_worked" id="hours_worked" class="block w-full mt-1" min="0.1" step="0.01" value="{{ old('hours_worked') }}" required>
                            @error('hours_worked')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Horas
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>