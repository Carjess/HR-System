<x-app-layout>
    {{-- Encabezado --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Perfil de: {{ $empleado->name }}
        </h2>
    </x-slot>

    {{-- Contenido --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- SECCIÓN 1: Detalles del Empleado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Información Personal</h3>
                    <p><strong>Email:</strong> {{ $empleado->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
                    <p><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
                    <p><strong>Puesto:</strong> {{ $empleado->position->name ?? 'N/A' }}</p>
                    <p><strong>Fecha de Contratación:</strong> {{ $empleado->fecha_contratacion }}</p>
                </div>
            </div>

            <!-- SECCIÓN 2: Historial de Contratos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Historial de Contratos</h3>
                        @can('is-admin')
                            <!-- Botón solo para admins -->
                            <a href="{{ route('empleados.contratos.create', $empleado->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Añadir Nuevo Contrato
                            </a>
                        @endcan
                    </div>

                    <!-- Tabla de Contratos -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Salario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fecha Inicio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fecha Fin</th>
                                @can('is-admin')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($empleado->contracts as $contract)
                                <tr>
                                    <td class="px-6 py-4">{{ $contract->type->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">${{ number_format($contract->salary, 2) }}</td>
                                    <td class="px-6 py-4">{{ $contract->start_date }}</td>
                                    <td class="px-6 py-4">{{ $contract->end_date ?? 'Indefinido' }}</td>
                                    @can('is-admin')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('contratos.edit', $contract->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('contratos.destroy', $contract->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600" onclick="return confirm('¿Estás seguro?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Este empleado aún no tiene contratos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN 3: Facturación de Horas (Timesheets) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Facturación de Horas</h3>
                        <!-- Botón disponible para el empleado -->
                        <a href="{{ route('timesheets.create', $empleado->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Registrar Horas
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($empleado->timesheets->sortByDesc('date') as $timesheet)
                                <tr>
                                    <td class="px-6 py-4">{{ $timesheet->date }}</td>
                                    <td class="px-6 py-4">{{ $timesheet->hours_worked }}</td>
                                    <td class="px-6 py-4">{{ $timesheet->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('timesheets.edit', $timesheet->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('timesheets.destroy', $timesheet->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600" onclick="return confirm('¿Seguro?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay horas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN 4: Historial de Nómina -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Historial de Nómina</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Período</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Base</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Neto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($empleado->payslips->sortByDesc('pay_period_start') as $payslip)
                                <tr>
                                    <td class="px-6 py-4">{{ $payslip->pay_period_start }}</td>
                                    <td class="px-6 py-4">${{ number_format($payslip->base_salary, 2) }}</td>
                                    <td class="px-6 py-4">{{ $payslip->total_hours }}</td>
                                    <td class="px-6 py-4 font-bold">${{ number_format($payslip->net_pay, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay recibos de nómina.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN 5: Solicitudes de Ausencia (CON MODAL Y ARREGLO DE TEXTO) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Mis Ausencias y Vacaciones</h3>
                        
                        <!-- Botón Solicitar -->
                        <a href="{{ route('ausencias.create', $empleado->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Solicitar Ausencia
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Desde</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hasta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Motivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($empleado->leaveRequests->sortByDesc('created_at') as $request)
                                {{-- x-data para el modal de cada fila --}}
                                <tr x-data="{ showModal: false }">
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</td>
                                    
                                    {{-- ARREGLO DE TEXTO: 'truncate' y 'max-w-xs' evitan que la tabla se rompa --}}
                                    <td class="px-6 py-4 truncate max-w-xs">
                                        {{ $request->reason ?? '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if($request->status === 'aprobado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Aprobado</span>
                                        @elseif($request->status === 'rechazado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Rechazado</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Botón Ver Detalles -->
                                    <td class="px-6 py-4">
                                        <button @click="showModal = true" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-bold">
                                            Ver Detalles
                                        </button>

                                        <!-- ==================== MODAL DEL EMPLEADO ==================== -->
                                        <div x-show="showModal" 
                                             style="display: none;"
                                             class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 md:h-full">
                                            
                                            <div class="relative w-full h-full max-w-2xl md:h-auto" @click.away="showModal = false">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                                                    <!-- Cabecera -->
                                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Detalles de mi Solicitud
                                                        </h3>
                                                        <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                    </div>

                                                    <!-- Cuerpo -->
                                                    <div class="p-6 space-y-6">
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</p>
                                                                <p class="mt-1">
                                                                    @if($request->status === 'aprobado')
                                                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Aprobado</span>
                                                                    @elseif($request->status === 'rechazado')
                                                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Rechazado</span>
                                                                    @else
                                                                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Pendiente</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fechas</p>
                                                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                                                    {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Motivo (ARREGLO: break-all para palabras largas) -->
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Mi Motivo</p>
                                                            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-sm leading-relaxed break-words whitespace-normal">
                                                                {{ $request->reason ?? 'Sin motivo.' }}
                                                            </div>
                                                        </div>

                                                        <!-- Respuesta del Admin (Si existe) -->
                                                        @if($request->admin_response)
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Respuesta de la Empresa</p>
                                                                <div class="p-4 border rounded-lg bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-gray-900 dark:text-white text-sm leading-relaxed break-words whitespace-normal">
                                                                    {{ $request->admin_response }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Pie -->
                                                    <div class="flex items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button @click="showModal = false" class="ml-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ==================== FIN MODAL ==================== -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay solicitudes de ausencia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div> 
    </div>
</x-app-layout>