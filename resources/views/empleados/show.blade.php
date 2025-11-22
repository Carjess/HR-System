<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Perfil de: {{ $empleado->name }}
        </h2>
    </x-slot>

    <!-- Inicializamos x-data para el modal de contrato (solo admin usa esto, pero no estorba) -->
    <div class="py-12" x-data="{ showContractModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- SECCIÓN 1: Detalles del Empleado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 border-b dark:border-gray-700 pb-2">Información Personal</h3>
                            <p class="mb-2"><strong class="text-gray-600 dark:text-gray-400">Email:</strong> {{ $empleado->email }}</p>
                            <p class="mb-2"><strong class="text-gray-600 dark:text-gray-400">Teléfono:</strong> {{ $empleado->telefono ?? 'No registrado' }}</p>
                            <p class="mb-2"><strong class="text-gray-600 dark:text-gray-400">Dirección:</strong> {{ $empleado->direccion ?? 'No registrada' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 border-b dark:border-gray-700 pb-2">Información Laboral</h3>
                            <p class="mb-2"><strong class="text-gray-600 dark:text-gray-400">Departamento:</strong> {{ $empleado->position->department->name ?? 'Sin Asignar' }}</p>
                            <p class="mb-2"><strong class="text-gray-600 dark:text-gray-400">Puesto:</strong> {{ $empleado->position->name ?? 'Sin Asignar' }}</p>
                            <p class="mb-2"><strong class="text-gray-600 dark:text-gray-400">Fecha de Ingreso:</strong> {{ $empleado->fecha_contratacion ? \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 2: Historial de Contratos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Historial de Contratos</h3>
                        @can('is-admin')
                            <!-- Botón que abre el Modal -->
                            <button @click="showContractModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Añadir Nuevo Contrato
                            </button>
                        @endcan
                    </div>

                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($empleado->contracts as $contract)
                                <div class="flex flex-wrap items-center gap-y-4 py-4">
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipo</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $contract->type->name ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Salario</dt>
                                        <dd class="mt-1 text-sm font-bold text-green-600 dark:text-green-400">${{ number_format($contract->salary, 2) }}</dd>
                                    </dl>
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Inicio</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</dd>
                                    </dl>
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Fin</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') : 'Indefinido' }}</dd>
                                    </dl>
                                    @can('is-admin')
                                        <div class="w-full sm:w-auto flex items-center justify-end gap-2">
                                            <a href="{{ route('contratos.edit', $contract->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 text-sm font-medium">Editar</a>
                                            <form method="POST" action="{{ route('contratos.destroy', $contract->id) }}" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm font-medium ml-2" onclick="return confirm('¿Eliminar este contrato?')">Eliminar</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            @empty
                                <div class="py-6 text-center text-gray-500 dark:text-gray-400 italic">Este empleado aún no tiene contratos registrados.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 3: Facturación de Horas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Facturación de Horas</h3>
                        <a href="{{ route('timesheets.create', $empleado->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-colors">Registrar Horas</a>
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
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($timesheet->date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">{{ $timesheet->hours_worked }}</td>
                                    <td class="px-6 py-4">{{ ucfirst($timesheet->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('timesheets.edit', $timesheet->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mr-3">Editar</a>
                                        <form method="POST" action="{{ route('timesheets.destroy', $timesheet->id) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" onclick="return confirm('¿Seguro?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay horas registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN 4: Historial de Nómina (MEJORADO CON MODAL) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Historial de Nómina</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Período</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Neto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($empleado->payslips->sortByDesc('pay_period_start') as $payslip)
                                <tr x-data="{ showPayslipModal: false }">
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($payslip->pay_period_start)->format('d/m') }} - {{ \Carbon\Carbon::parse($payslip->pay_period_end)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-green-600 dark:text-green-400">${{ number_format($payslip->net_pay, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <button @click="showPayslipModal = true" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-bold">Ver Recibo</button>
                                        
                                        <!-- MODAL DETALLES DE NÓMINA -->
                                        <div x-show="showPayslipModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                            <div class="relative w-full max-w-lg h-auto" @click.away="showPayslipModal = false">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-6 space-y-4">
                                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recibo de Pago</h3>
                                                    
                                                    <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-sm">
                                                        <div class="text-gray-500">Salario Base</div>
                                                        <div class="text-right font-semibold dark:text-white">${{ number_format($payslip->base_salary, 2) }}</div>
                                                        
                                                        <div class="text-gray-500">Horas Registradas</div>
                                                        <div class="text-right font-semibold dark:text-white">{{ $payslip->total_hours }} hrs</div>
                                                        
                                                        <div class="text-gray-500">Bonos</div>
                                                        <div class="text-right font-semibold text-green-600">+ ${{ number_format($payslip->bonuses, 2) }}</div>
                                                        
                                                        <div class="text-gray-500">Deducciones</div>
                                                        <div class="text-right font-semibold text-red-600">- ${{ number_format($payslip->deductions, 2) }}</div>
                                                        
                                                        <div class="col-span-2 border-t dark:border-gray-600 my-2"></div>
                                                        
                                                        <div class="text-lg font-bold text-gray-900 dark:text-white">Total Neto</div>
                                                        <div class="text-right text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($payslip->net_pay, 2) }}</div>
                                                    </div>

                                                    <!-- Mensaje del Admin -->
                                                    @if($payslip->notes)
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Mensaje / Nota</p>
                                                            <div class="p-4 border rounded-lg bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-gray-900 dark:text-white text-sm leading-relaxed break-words">
                                                                {{ $payslip->notes }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="flex justify-end"><button @click="showPayslipModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Cerrar</button></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIN MODAL -->
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay recibos de nómina.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN 5: Solicitudes de Ausencia -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Mis Ausencias y Vacaciones</h3>
                        <a href="{{ route('ausencias.create', $empleado->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition-colors">Solicitar Ausencia</a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fechas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Motivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($empleado->leaveRequests->sortByDesc('created_at') as $request)
                                <tr x-data="{ showModal: false }">
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/y') }}</td>
                                    <td class="px-6 py-4 truncate max-w-xs">{{ $request->reason ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($request->status === 'aprobado') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprobado</span>
                                        @elseif($request->status === 'rechazado') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazado</span>
                                        @else <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <button @click="showModal = true" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-bold">Ver</button>
                                        <!-- MODAL DETALLE AUSENCIA -->
                                        <div x-show="showModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                            <div class="relative w-full max-w-lg h-auto" @click.away="showModal = false">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-6 space-y-4">
                                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Detalles de Solicitud</h3>
                                                    <div><strong class="text-gray-500">Estado:</strong> {{ ucfirst($request->status) }}</div>
                                                    <div><strong class="text-gray-500">Motivo:</strong> <p class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded break-words">{{ $request->reason }}</p></div>
                                                    @if($request->admin_response)
                                                        <div><strong class="text-gray-500">Respuesta:</strong> <p class="mt-1 p-3 bg-blue-50 dark:bg-blue-900/20 rounded break-words">{{ $request->admin_response }}</p></div>
                                                    @endif
                                                    <div class="flex justify-end"><button @click="showModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Cerrar</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay solicitudes.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL CREAR CONTRATO (ADMIN) ==================== -->
        @can('is-admin')
        <div x-show="showContractModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-lg h-auto max-h-full overflow-y-auto" @click.away="showContractModal = false">
                <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    
                    <div class="flex justify-between p-4 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nuevo Contrato para {{ $empleado->name }}</h3>
                        <button @click="showContractModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('empleados.contratos.store', $empleado->id) }}" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label for="contract_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Contrato</label>
                            <select name="contract_type_id" id="contract_type_id" required onchange="updateSalary(this)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">-- Seleccionar --</option>
                                @foreach ($contractTypes as $type)
                                    <option value="{{ $type->id }}" data-salary="{{ $type->salary }}">
                                        {{ $type->name }} (Base: ${{ number_format($type->salary, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salario Mensual ($)</label>
                            <input type="number" name="salary" id="salary_input" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inicio</label>
                                <input type="date" name="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </div>
                            <div>
                                <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fin (Opcional)</label>
                                <input type="date" name="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="button" @click="showContractModal = false" class="mr-2 text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white">Cancelar</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">Guardar Contrato</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan

    </div>

    <script>
        function updateSalary(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var salary = selectedOption.getAttribute('data-salary');
            document.getElementById('salary_input').value = salary;
        }
    </script>

</x-app-layout>