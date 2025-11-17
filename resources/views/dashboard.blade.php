<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-600">Total Empleados</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalEmpleados }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-600">Contratos Activos</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalContratosActivos }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-600">Horas (Este Mes)</h3>
                        <p class="text-3xl font-bold mt-2">{{ number_format($horasEsteMes, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Accesos Directos</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('empleados.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Añadir Empleado
                        </a>
                        <a href="{{ route('payroll.index') }}" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                            Correr Nómina
                        </a>
                        <a href="{{ route('tipos-contrato.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Ver Tipos de Contrato
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Contrataciones Recientes</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Puesto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Contrato</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($empleadosRecientes as $empleado)
                                <tr>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('empleados.show', $empleado->id) }}" class="text-blue-600 hover:underline">
                                            {{ $empleado->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">{{ $empleado->position->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $empleado->fecha_contratacion }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay contrataciones recientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>