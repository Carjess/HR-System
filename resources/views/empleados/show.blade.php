<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Perfil de: {{ $empleado->name }}
        </h2>
    </x-slot>
    
    <style>
        .btn-anim { transition: all 250ms; }
        .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
        .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }
        
        .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
        .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
        .dark .row-card:hover { background-color: #374151; }
    </style>

    <!-- 
      Ajuste de márgenes y ESTADO ALPINE para todos los modales 
    -->
    <div class="pb-12 relative -mt-4 -mx-4" x-data="{ showContractModal: false, showLeaveModal: false, showTimesheetModal: false }">
        
        <!-- Mensaje de Éxito -->
        @if (session('status'))
            <div x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(()=> show = false, 4000)"
                x-transition
                class="fixed right-4 bottom-4 z-50">
                <div class="max-w-xs w-full bg-emerald-600 text-white rounded-lg shadow-lg border border-emerald-700 p-3 flex items-start gap-3">
                    <svg class="w-5 h-5 text-white mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 19a7 7 0 100-14 7 7 0 000 14z"/></svg>
                    <div class="text-sm font-medium leading-tight">
                        {{ session('status') }}
                    </div>
                    <button @click="show = false" class="ml-3 text-white/80 hover:text-white text-sm">✕</button>
                </div>
            </div>
        @endif

        <!-- 1. BANNER Y TARJETA PRINCIPAL -->
        <div class="relative mb-12">
            <!-- Fondo Azul Degradado -->
            <div class="h-48 w-full bg-gradient-to-r from-teal-800 to-emerald-400 dark:from-teal-800 to-emerald-400 rounded-b-[3rem] shadow-md absolute top-0 left-0 z-0"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="md:flex">
                        <!-- Columna Izquierda: Avatar y Rol -->
                        <div class="md:w-1/3 bg-gray-50 dark:bg-gray-900/50 p-8 flex flex-col items-center justify-center border-r border-gray-100 dark:border-gray-700 text-center">
                            <div class="h-32 w-32 rounded-full bg-white p-1 shadow-lg mb-4">
                                <div class="h-full w-full rounded-full bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 flex items-center justify-center text-4xl font-bold text-blue-600 dark:text-blue-300">
                                    {{ substr($empleado->name, 0, 1) }}
                                </div>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $empleado->name }}</h1>
                            <p class="text-blue-600 dark:text-blue-400 font-medium mt-1 mb-6">{{ $empleado->position->name ?? 'Sin Cargo Asignado' }}</p>
                            
                            <!-- BOTÓN ABRIR CHAT -->
                            @if(auth()->id() !== $empleado->id)
                            <div class="w-full max-w-xs">
                                <button type="button" 
                                        onclick="openChatAsync({{ $empleado->id }})" 
                                        class="btn-anim flex items-center justify-center gap-2 px-6 py-2.5 bg-green-600 text-white rounded-full font-bold shadow-md hover:bg-green-700 transition-colors w-full cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Abrir Chat
                                </button>
                            </div>
                            @endif
                        </div>

                        <!-- Columna Derecha: Detalles -->
                        <div class="md:w-2/3 p-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-2 dark:border-gray-700">Información General</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">Departamento</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ $empleado->position->department->name ?? 'General' }}
                                        </span>
                                    </p>
                                </div>
                                <div><p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Fecha Ingreso</p><p class="text-base font-medium dark:text-white mt-1">{{ $empleado->fecha_contratacion ? \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d M, Y') : 'N/A' }}</p></div>
                                <div><p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Email</p><p class="text-base font-medium dark:text-white mt-1">{{ $empleado->email }}</p></div>
                                <div><p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Teléfono</p><p class="text-base font-medium dark:text-white mt-1">{{ $empleado->telefono ?? 'No registrado' }}</p></div>
                                <div><p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Dirección</p><p class="text-base font-medium dark:text-white mt-1">{{ $empleado->direccion ?? 'No registrada' }}</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- SECCIÓN 2: Contratos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                            Contratos
                        </h3>
                        @can('is-admin')
                            <button @click="showContractModal = true" class="btn-anim bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl flex items-center gap-2 text-sm shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Nuevo Contrato
                            </button>
                        @endcan
                    </div>
                    
                    <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-sm text-white uppercase bg-primary-600 dark:bg-primary-90 font-bold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Tipo</th>
                                    <th class="px-6 py-4">Salario</th>
                                    <th class="px-6 py-4">Periodo</th>
                                    <th class="px-6 py-4 text-right">Estado</th> 
                                    @can('is-admin')<th class="px-6 py-4 text-right">Acciones</th>@endcan
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($empleado->contracts as $contract)
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors hover:bg-gray-50">
                                        <td class="px-6 py-5 text-base font-medium text-gray-900 dark:text-white">{{ $contract->type->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-5 font-bold text-green-600 dark:text-green-400">${{ number_format($contract->salary, 2) }}</td>
                                        <td class="px-6 py-5"><div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($contract->start_date)->format('d M, Y') }}</div><div class="text-xs text-gray-500">{{ $contract->end_date ? 'Hasta ' . \Carbon\Carbon::parse($contract->end_date)->format('d M, Y') : 'Indefinido' }}</div></td>
                                        <td class="px-6 py-5 text-right">
                                            @if(!$contract->end_date || \Carbon\Carbon::parse($contract->end_date)->isFuture()) <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Activo</span>
                                            @else <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Finalizado</span> @endif
                                        </td>
                                        @can('is-admin')
                                        <td class="px-6 py-5 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('contratos.edit', $contract->id) }}" class="text-gray-400 hover:text-blue-600 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                                <form method="POST" action="{{ route('contratos.destroy', $contract->id) }}" class="inline">@csrf @method('DELETE')<button type="submit" class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" onclick="return confirm('¿Eliminar?')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>
                                @empty <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">No hay contratos registrados.</td></tr> @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- SECCIÓN 3: Horas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 h-full">
                    <div class="p-8 flex flex-col h-full">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2"><div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div> Horas</h3>
                            
                            <!-- BOTÓN "REGISTRAR" AHORA ABRE MODAL -->
                            <button @click="showTimesheetModal = true" class="btn-anim bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl text-sm shadow-md">
                                Registrar
                            </button>
                        </div>
                        <div class="flex-grow overflow-auto max-h-96 rounded-xl border border-gray-100 dark:border-gray-700">
                            <table class="w-full text-left text-gray-500 dark:text-gray-400">
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse ($empleado->timesheets->sortByDesc('date') as $timesheet)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="py-4 px-4"><div class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($timesheet->date)->format('d M') }}</div><div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($timesheet->date)->format('Y') }}</div></td>
                                            <td class="py-4 px-4 text-right"><span class="text-lg font-bold text-gray-900 dark:text-white">{{ $timesheet->hours_worked }}h</span></td>
                                            <td class="py-4 px-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('timesheets.edit', $timesheet->id) }}" class="text-gray-400 hover:text-blue-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></a>
                                                    <form method="POST" action="{{ route('timesheets.destroy', $timesheet->id) }}" class="inline">@csrf @method('DELETE')<button type="submit" class="text-gray-400 hover:text-red-500" onclick="return confirm('¿Borrar?')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty <tr><td colspan="3" class="py-8 text-center text-gray-400 italic">Sin registros.</td></tr> @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: Nómina -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 h-full">
                    <div class="p-8 flex flex-col h-full">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg text-purple-600 dark:text-purple-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pagos Recibidos</h3>
                        </div>
                        <div class="flex-grow overflow-auto max-h-96 rounded-xl border border-gray-100 dark:border-gray-700">
                            <table class="w-full text-left text-gray-500 dark:text-gray-400">
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse ($empleado->payslips->sortByDesc('pay_period_start') as $payslip)
                                        <tr x-data="{ showPayslipModal: false }" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer" @click="showPayslipModal = true">
                                            <td class="py-4 px-4"><div class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($payslip->pay_period_start)->translatedFormat('F Y') }}</div><div class="text-xs text-gray-400">ID: #{{ $payslip->id }}</div></td>
                                            <td class="py-4 px-4 text-right"><div class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($payslip->net_pay, 2) }}</div></td>
                                            <template x-teleport="body">
                                                <div x-show="showPayslipModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full" @click.stop="">
                                                    <div class="relative w-full max-w-md h-auto" @click.away="showPayslipModal = false">
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                                                            <div class="text-center border-b border-gray-100 dark:border-gray-700 pb-4"><h3 class="text-2xl font-bold text-gray-900 dark:text-white">Recibo de Pago</h3><p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($payslip->pay_period_start)->format('d/m/Y') }}</p></div>
                                                            <div class="space-y-3 text-sm"><div class="flex justify-between"><span class="text-gray-500">Base</span><span class="font-semibold dark:text-white">${{ number_format($payslip->base_salary, 2) }}</span></div><div class="flex justify-between"><span class="text-gray-500">Horas</span><span class="font-semibold dark:text-white">{{ $payslip->total_hours }}</span></div><div class="flex justify-between text-green-600"><span class="">Bonificaciones</span><span class="font-semibold">+ ${{ number_format($payslip->bonuses, 2) }}</span></div><div class="flex justify-between text-red-500"><span class="">Deducciones</span><span class="font-semibold">- ${{ number_format($payslip->deductions, 2) }}</span></div><div class="flex justify-between pt-4 border-t text-lg font-bold dark:text-white"><span>Neto</span><span>${{ number_format($payslip->net_pay, 2) }}</span></div></div>
                                                            @if($payslip->notes) <div class="bg-blue-50 p-4 rounded-xl text-sm text-blue-800"><strong>Nota:</strong> {{ $payslip->notes }}</div> @endif
                                                            <button @click="showPayslipModal = false" class="w-full bg-gray-100 hover:bg-gray-200 font-bold py-3 px-4 rounded-xl">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </tr>
                                    @empty <tr><td colspan="2" class="py-8 text-center text-gray-400 italic">Sin pagos.</td></tr> @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 5: Ausencias (Limitado a 5) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <div class="p-2 bg-orange-100 dark:bg-orange-900/50 rounded-lg text-orange-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div> Últimas Ausencias
                        </h3>
                        
                        <!-- BOTÓN "SOLICITAR" AHORA ABRE MODAL -->
                        <button @click="showLeaveModal = true" class="btn-anim bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-colors text-sm">
                            Solicitar
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-sm text-white uppercase bg-primary-600 dark:bg-primary-90 font-bold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Fechas</th>
                                    <th class="px-6 py-4">Motivo</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4 text-right">Detalles</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Se aplica el límite de 5 -->
                                @forelse ($empleado->leaveRequests->sortByDesc('created_at')->take(5) as $request)
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors hover:bg-gray-50" x-data="{ showModal: false }">
                                        <td class="px-6 py-5 font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d M') }}</td>
                                        <td class="px-6 py-5 truncate max-w-xs">{{ $request->reason ?? '-' }}</td>
                                        <td class="px-6 py-5">
                                            @if($request->status === 'aprobado') <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Aprobado</span>
                                            @elseif($request->status === 'rechazado') <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Rechazado</span>
                                            @else <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Pendiente</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <button @click="showModal = true" class="text-blue-600 hover:text-blue-800 font-bold text-sm">Ver</button>
                                            <template x-teleport="body">
                                                <div x-show="showModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full" @click.stop="">
                                                    <div class="relative w-full max-w-lg h-auto" @click.away="showModal = false">
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 p-8 space-y-6 border border-gray-200 dark:border-gray-700">
                                                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white border-b pb-4">Detalles</h3>
                                                            <div><p class="text-xs text-gray-500 font-bold uppercase">Estado</p><p class="text-base capitalize font-medium text-gray-900 dark:text-white">{{ $request->status }}</p></div>
                                                            <div><p class="text-xs text-gray-500 font-bold uppercase">Motivo</p><div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-sm italic">"{{ $request->reason }}"</div></div>
                                                            @if($request->admin_response) <div><p class="text-xs text-blue-600 font-bold uppercase">Respuesta Admin</p><div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 rounded-xl text-sm text-blue-800">{{ $request->admin_response }}</div></div> @endif
                                                            <div class="text-right pt-4"><button @click="showModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-xl">Cerrar</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">No has solicitado ausencias.</td></tr> @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Botón "Ver Historial" si hay más de 5 -->
                    @if($empleado->leaveRequests->count() > 5)
                    <div class="mt-4 text-center border-t border-gray-100 dark:border-gray-700 pt-4">
                        <a href="#" class="text-sm font-bold text-primary-600 hover:text-primary-800 transition-colors">Ver historial completo de ausencias &rarr;</a>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- ==================== MODAL CONTRATO (ADMIN) ==================== -->
        @can('is-admin')
        <div x-show="showContractModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-lg h-auto max-h-full overflow-y-auto" @click.away="showContractModal = false">
                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Nuevo Contrato</h3>
                        <button @click="showContractModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                    </div>
                    <form method="POST" action="{{ route('empleados.contratos.store', $empleado->id) }}" class="p-8 space-y-6">
                        @csrf
                        <div><label class="block mb-2 text-base font-medium dark:text-white">Tipo</label><select name="contract_type_id" id="contract_type_id" required onchange="updateSalary(this)" class="bg-gray-50 border border-gray-300 rounded-xl w-full p-3 dark:bg-gray-700 dark:text-white"><option value="">-- Seleccionar --</option>@foreach ($contractTypes as $type) <option value="{{ $type->id }}" data-salary="{{ $type->salary }}">{{ $type->name }} (Base: ${{ number_format($type->salary, 2) }})</option> @endforeach</select></div>
                        <div><label class="block mb-2 text-base font-medium dark:text-white">Salario</label><input type="number" name="salary" id="salary_input" step="0.01" class="bg-gray-50 border border-gray-300 rounded-xl w-full p-3 dark:bg-gray-700 dark:text-white" required></div>
                        <div class="grid grid-cols-2 gap-6"><div><label class="block mb-2 text-base font-medium dark:text-white">Inicio</label><input type="date" name="start_date" class="bg-gray-50 border border-gray-300 rounded-xl w-full p-3 dark:bg-gray-700 dark:text-white" required></div><div><label class="block mb-2 text-base font-medium dark:text-white">Fin (Opcional)</label><input type="date" name="end_date" class="bg-gray-50 border border-gray-300 rounded-xl w-full p-3 dark:bg-gray-700 dark:text-white"></div></div>
                        <div class="flex justify-end pt-2"><button type="button" @click="showContractModal = false" class="mr-3 text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 font-bold rounded-xl px-6 py-3">Cancelar</button><button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl px-8 py-3 shadow-md">Guardar</button></div>
                    </form>
                </div>
            </div>
        </div>
        @endcan

        <!-- ==================== MODAL SOLICITAR AUSENCIA ==================== -->
        <div x-show="showLeaveModal" style="display: none;" x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 transition-opacity">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100" @click.away="showLeaveModal = false">
                <div class="bg-purple-600 p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Solicitar Ausencia
                    </h3>
                    <button @click="showLeaveModal = false" class="text-purple-100 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('ausencias.store', $empleado->id) }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $empleado->id }}">
                    <div class="space-y-4">
                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tipo de Ausencia</label><select name="type" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><option value="vacaciones">Vacaciones</option><option value="medico">Cita Médica</option><option value="personal">Asunto Personal</option><option value="enfermedad">Enfermedad</option></select></div>
                        <div class="grid grid-cols-2 gap-4"><div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Desde</label><input type="date" name="start_date" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></div><div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Hasta</label><input type="date" name="end_date" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></div></div>
                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Motivo / Comentario</label><textarea name="reason" rows="3" placeholder="Explica brevemente el motivo..." class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea></div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showLeaveModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-bold transition-colors dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 font-bold shadow-lg transition-colors">Enviar Solicitud</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== MODAL REGISTRAR HORAS ==================== -->
        <div x-show="showTimesheetModal" style="display: none;" x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 transition-opacity">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100" @click.away="showTimesheetModal = false">
                <div class="bg-blue-600 p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Registrar Horas
                    </h3>
                    <button @click="showTimesheetModal = false" class="text-blue-100 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('timesheets.store', $empleado->id) }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $empleado->id }}">
                    <div class="space-y-4">
                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Fecha</label><input type="date" name="date" value="{{ date('Y-m-d') }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></div>
                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Horas Trabajadas</label><input type="number" step="0.5" min="0" max="24" name="hours_worked" placeholder="Ej: 8" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></div>
                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Descripción / Proyecto</label><textarea name="description" rows="3" placeholder="¿Qué hiciste hoy?" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea></div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showTimesheetModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-bold transition-colors dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold shadow-lg transition-colors">Guardar Registro</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function updateSalary(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            document.getElementById('salary_input').value = selectedOption.getAttribute('data-salary');
        }

        // --- FUNCIÓN PARA ABRIR CHAT SIN RECARGAR (AJAX) ---
        async function openChatAsync(userId) {
            try {
                // 1. Petición al servidor (AJAX)
                const response = await fetch(`/chat/open/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest' // Importante para que Laravel sepa que es AJAX
                    }
                });

                if (response.ok) {
                    const html = await response.text();
                    // Intentamos parsear JSON por si el controlador envía JSON
                    let parsedHtml = html;
                    try {
                        const json = JSON.parse(html);
                        if (json.html) parsedHtml = json.html;
                    } catch(e) {
                        // Si no es JSON, es HTML directo, seguimos
                    }
                    
                    // 2. Si ya existe un chat abierto, lo quitamos para poner el nuevo
                    const existingChat = document.querySelector('[x-data="chatWidget()"]');
                    if (existingChat) {
                        existingChat.remove();
                    }

                    // 3. Inyectamos el HTML del widget en el cuerpo de la página
                    const tempContainer = document.createElement('div');
                    tempContainer.innerHTML = parsedHtml;
                    
                    while (tempContainer.firstChild) {
                        document.body.appendChild(tempContainer.firstChild);
                    }
                    
                } else {
                    console.error("Error abriendo chat");
                }
            } catch (error) {
                console.error("Error de red:", error);
            }
        }
    </script>
</x-app-layout>