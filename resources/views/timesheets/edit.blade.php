<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Registro de Horas ({{ $timesheet->employee->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('timesheets.update', $timesheet->id) }}">
                        @csrf 
                        @method('PATCH')

                        <div class="mt-4">
                            <label for="date">Fecha:</label>
                            <input type="date" name="date" id="date" class="block w-full mt-1" value="{{ old('date', $timesheet->date) }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="hours_worked">Horas Trabajadas:</label>
                            <input type="number" name="hours_worked" id="hours_worked" class="block w-full mt-1" min="0.1" step="0.01" value="{{ old('hours_worked', $timesheet->hours_worked) }}" required>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Horas
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>