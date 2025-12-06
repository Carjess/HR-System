<x-app-layout>
    <x-slot name="header">
        

        <!-- ESTILOS PREMIUM -->
        <style>
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }
            
            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }
        </style>
    </x-slot>

    <div class="py-8" x-data="{ showTimesheetModal: false, showLeaveModal: false }">
        
        <!-- ALERTA DE ÉXITO -->
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="p-4 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- 1. SECCIÓN DE BIENVENIDA Y RESUMEN -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Tarjeta de Perfil Principal -->
                <div class="col-span-1 lg:col-span-2 bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl shadow-xl overflow-hidden relative text-white p-8 group">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl group-hover:opacity-20 transition-opacity duration-700"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-white/20 backdrop-blur-sm border-2 border-white/30 flex items-center justify-center text-3xl font-bold shadow-lg">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="text-3xl font-bold mb-1">Hola, {{ explode(' ', $user->name)[0] }}!</h3>
                            <p class="text-primary-100 text-lg font-medium mb-4">{{ $user->position->name ?? 'Empleado' }} • {{ $user->position->department->name ?? 'General' }}</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('empleados.show', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-semibold transition-all backdrop-blur-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Ver Mi Perfil Completo
                                </a>
                                <a href="{{ route('calendar.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-primary-700 hover:bg-gray-50 border border-transparent rounded-xl text-sm font-bold shadow-md transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Ver Agenda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Resumen Rápido -->
                <div class="col-span-1 bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 flex flex-col justify-between">
                    <div>
                        <h4 class="text-gray-500 dark:text-gray-400 font-bold text-xs uppercase tracking-wider mb-4">Tu Actividad (Este Mes)</h4>
                        <div class="flex items-end gap-2 mb-2">
                            <span class="text-5xl font-black text-gray-900 dark:text-white">{{ $hoursThisMonth ?? 0 }}</span>
                            <span class="text-lg font-medium text-gray-500 dark:text-gray-400 mb-1">hrs</span>
                        </div>
                        <p class="text-sm text-gray-500">Horas registradas</p>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Vacaciones Disponibles</span>
                            <span class="text-sm font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-lg">12 Días</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. ACCESOS RÁPIDOS -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-orange-500 rounded-full"></span>
                    ¿Qué quieres hacer hoy?
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Registrar Horas -->
                    <button @click="showTimesheetModal = true" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 text-left w-full">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-1">Registrar Horas</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Añade tu jornada laboral diaria.</p>
                    </button>

                    <!-- Solicitar Vacaciones -->
                    <button @click="showLeaveModal = true" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 text-left w-full">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-300 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-1">Solicitar Ausencia</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Vacaciones, permisos médicos, etc.</p>
                    </button>

                    <!-- Mis Recibos -->
                    <a href="{{ route('empleados.recibos.list', $user->id) }}" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 text-left block">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-300 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-1">Mis Recibos</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Descarga tus comprobantes.</p>
                    </a>

                    <!-- Contactar RRHH (BOTÓN CORREGIDO) -->
                    <a href="{{ route('messages.create_ticket') }}" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 text-left w-full block">
                        <div class="w-12 h-12 rounded-xl bg-pink-50 dark:bg-pink-900/30 text-pink-600 dark:text-pink-300 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-1">Contactar RRHH</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Crear nuevo ticket de soporte.</p>
                    </a>
                </div>
            </div>

            <!-- 3. ÚLTIMAS SOLICITUDES -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <div class="p-2 bg-orange-100 dark:bg-orange-900/50 rounded-lg text-orange-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div> Últimas Solicitudes
                        </h3>
                        
                        <!-- Botón "Ver Historial Completo" (Naranja) -->
                        <a href="{{ route('empleados.ausencias.list', $user->id) }}" class="btn-anim bg-orange-100 hover:bg-orange-200 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300 dark:hover:bg-orange-900/50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-colors text-sm flex items-center gap-2">
                            Ver Historial Completo
                            
                        </a>
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
                                <!-- Limitado a 5 registros -->
                                @forelse ($leaveRequests->sortByDesc('created_at')->take(5) as $request)
                                    <!-- Fila Clicable + Modal Integrado -->
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors hover:bg-gray-50 cursor-pointer" 
                                        x-data="{ showDetailModal: false }"
                                        @click="showDetailModal = true">
                                        
                                        <td class="px-6 py-5 font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d M') }}
                                        </td>
                                        <td class="px-6 py-5 truncate max-w-xs">{{ $request->reason ?? '-' }}</td>
                                        <td class="px-6 py-5">
                                            @if($request->status === 'aprobado') 
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Aprobado</span>
                                            @elseif($request->status === 'rechazado') 
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Rechazado</span>
                                            @else 
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Pendiente</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <!-- Icono Minimalista -->
                                            <button type="button" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all" title="Ver Detalles">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            
                                            <!-- MODAL DE DETALLE (Con Fade y Clic Fuera) -->
                                            <template x-teleport="body">
                                                <div x-show="showDetailModal" style="display: none;" x-cloak 
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full" 
                                                     @click.stop="showDetailModal = false" 
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0">
                                                    
                                                    <div class="relative w-full max-w-lg h-auto" @click.stop
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="transition ease-in duration-200"
                                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                                        
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 p-8 space-y-6 border border-gray-200 dark:border-gray-700">
                                                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white border-b pb-4">Detalles de Solicitud</h3>
                                                            
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div><p class="text-xs text-gray-500 font-bold uppercase">Tipo</p><p class="text-base capitalize font-medium text-gray-900 dark:text-white">{{ $request->type }}</p></div>
                                                                <div><p class="text-xs text-gray-500 font-bold uppercase">Estado</p><p class="text-base capitalize font-medium text-gray-900 dark:text-white">{{ $request->status }}</p></div>
                                                            </div>

                                                            <div>
                                                                <p class="text-xs text-gray-500 font-bold uppercase mb-1">Motivo</p>
                                                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-sm italic text-gray-700 dark:text-gray-300">"{{ $request->reason }}"</div>
                                                            </div>

                                                            @if($request->admin_response) 
                                                                <div>
                                                                    <p class="text-xs text-blue-600 font-bold uppercase">Respuesta Admin</p>
                                                                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 rounded-xl text-sm text-blue-800 dark:text-blue-300">{{ $request->admin_response }}</div>
                                                                </div> 
                                                            @endif
                                                            <div class="text-right pt-4">
                                                                <button @click="showDetailModal = false" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded-xl transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 shadow-lg">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty 
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">No has realizado solicitudes recientes.</td>
                                    </tr> 
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- MODAL TIMESHEET (Igual que antes) -->
        <div x-show="showTimesheetModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 transition-opacity" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100" @click.away="showTimesheetModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="bg-blue-600 p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Registrar Horas</h3>
                    <button @click="showTimesheetModal = false" class="text-blue-100 hover:text-white transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <form action="{{ route('timesheets.store', $user->id) }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
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

        <!-- MODAL LEAVE (Igual que antes) -->
        <div x-show="showLeaveModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 transition-opacity" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100" @click.away="showLeaveModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="bg-purple-600 p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Solicitar Ausencia</h3>
                    <button @click="showLeaveModal = false" class="text-purple-100 hover:text-white transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <form action="{{ route('ausencias.store', $user->id) }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
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
    </div>
</x-app-layout>