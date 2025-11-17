<x-app-layout>
    {{-- Encabezado --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfil de: {{ $empleado->name }}
        </h2>
    </x-slot>

    {{-- Contenido --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Información Personal</h3>
                    <p><strong>Email:</strong> {{ $empleado->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
                    <p><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
                    <p><strong>Puesto:</strong> {{ $empleado->position->name ?? 'N/A' }}</p>
                    <p><strong>Fecha de Contratación:</strong> {{ $empleado->fecha_contratacion }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Historial de Contratos</h3>
                        <a href="{{ route('empleados.contratos.create', $empleado->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Añadir Nuevo Contrato
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Fin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Aquí recorremos los contratos del empleado --}}
                            @forelse ($empleado->contracts as $contract)
                                <tr>
                                    <td class="px-6 py-4">{{ $contract->type->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">${{ number_format($contract->salary, 2) }}</td>
                                    <td class="px-6 py-4">{{ $contract->start_date }}</td>
                                    <td class="px-6 py-4">{{ $contract->end_date ?? 'Indefinido' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('contratos.edit', $contract->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('contratos.destroy', $contract->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('¿Estás seguro de que quieres eliminar este contrato?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Este empleado aún no tiene contratos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Facturación de Horas</h3>
                        <a href="{{ route('timesheets.create', $empleado->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Registrar Horas
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($empleado->timesheets->sortByDesc('date') as $timesheet)
                                <tr>
                                    <td class="px-6 py-4">{{ $timesheet->date }}</td>
                                    <td class="px-6 py-4">{{ $timesheet->hours_worked }}</td>
                                    <td class="px-6 py-4">{{ $timesheet->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('timesheets.edit', $timesheet->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('timesheets.destroy', $timesheet->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('¿Seguro que quieres eliminar este registro?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Este empleado aún no tiene horas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Historial de Nómina</h3>
                        {{-- (En el futuro, aquí podría ir un botón para ver el PDF) --}}
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salario Base</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horas Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deducciones</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pago Neto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse ($empleado->payslips->sortByDesc('pay_period_start') as $payslip)
                                <tr>
                                    <td class="px-6 py-4">{{ $payslip->pay_period_start }} al {{ $payslip->pay_period_end }}</td>
                                    <td class="px-6 py-4">${{ number_format($payslip->base_salary, 2) }}</td>
                                    <td class="px-6 py-4">{{ $payslip->total_hours }}</td>
                                    <td class="px-6 py-4 text-red-600">-${{ number_format($payslip->deductions, 2) }}</td>
                                    <td class="px-6 py-4 font-bold">${{ number_format($payslip->net_pay, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Este empleado aún no tiene recibos de nómina.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>