<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Ausencias') }}
        </h2>
        
        <style>
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #ffffff; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration { display: none; }
        </style>
    </x-slot>

    <div class="" x-data="{ showLeaveModal: false }">
        <div class="w-full">
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('status'))
                        <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 text-base border border-emerald-300 rounded-xl shadow-sm dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles Superiores -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                        <form method="GET" action="{{ route('empleados.ausencias.list', Auth::id()) }}" class="sm:flex sm:items-center gap-4 w-full sm:w-auto">
                            <div class="relative">
                                <input placeholder="Buscar por motivo..." class="input shadow-sm hover:shadow-md focus:shadow-lg focus:ring-2 focus:ring-primary-500 border-gray-300 px-5 py-3 rounded-xl w-56 transition-all focus:w-64 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium" name="search" type="search" value="{{ request('search') }}" />
                                <svg class="size-6 absolute top-3 right-3 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                            </div>
                            <div class="w-full sm:w-64">
                                <select name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm hover:shadow-md focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-medium transition-shadow">
                                    <option value="">Todos los Tipos</option>
                                    <option value="vacaciones" {{ request('type') == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                                    <option value="medico" {{ request('type') == 'medico' ? 'selected' : '' }}>Cita Médica</option>
                                    <option value="personal" {{ request('type') == 'personal' ? 'selected' : '' }}>Asunto Personal</option>
                                    <option value="enfermedad" {{ request('type') == 'enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-anim w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-md transition-colors">
                                Filtrar
                            </button>
                        </form>

                        <button @click="showLeaveModal = true" class="btn-anim w-full mt-4 sm:mt-0 sm:w-auto text-center text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800 flex items-center justify-center gap-2 shadow-md transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nueva Solicitud
                        </button>
                    </div>

                    <!-- TABLA DE AUSENCIAS -->
                    <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-90">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Tipo</th>
                                    <th scope="col" class="px-6 py-4">Fechas</th>
                                    <th scope="col" class="px-6 py-4">Motivo</th>
                                    <th scope="col" class="px-6 py-4 text-center">Estado</th>
                                    <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($ausencias as $ausencia)
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors cursor-pointer" 
                                        x-data="{ showDetailModal: false }"
                                        @click="showDetailModal = true">
                                        
                                        <td class="px-6 py-5 font-bold text-gray-900 dark:text-white capitalize">
                                            {{ $ausencia->type }}
                                        </td>

                                        <td class="px-6 py-5 text-base text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($ausencia->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($ausencia->end_date)->format('d M, Y') }}
                                            <div class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($ausencia->start_date)->diffInDays(\Carbon\Carbon::parse($ausencia->end_date)) + 1 }} días)</div>
                                        </td>

                                        <td class="px-6 py-5 text-sm text-gray-600 dark:text-gray-300 truncate max-w-xs">
                                            {{ $ausencia->reason }}
                                        </td>

                                        <td class="px-6 py-5 text-center">
                                            @if($ausencia->status === 'aprobado')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 shadow-sm">Aprobado</span>
                                            @elseif($ausencia->status === 'rechazado')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 shadow-sm">Rechazado</span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 shadow-sm">Pendiente</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-5 text-right">
                                            <button type="button" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all" title="Ver Detalles">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            
                                            <!-- MODAL DE DETALLE CORREGIDO -->
                                            <template x-teleport="body">
                                                <div x-show="showDetailModal" 
                                                     style="display: none;" 
                                                     x-cloak 
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full"
                                                     x-transition:enter="ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="ease-in duration-200"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0"
                                                     @click="showDetailModal = false"> <!-- Clic en backdrop cierra el modal -->

                                                    <div class="relative w-full max-w-lg h-auto" @click.stop> <!-- Clic dentro NO cierra -->
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 p-8 space-y-6 border border-gray-200 dark:border-gray-700"
                                                             x-transition:enter="ease-out duration-300"
                                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                             x-transition:leave="ease-in duration-200"
                                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                                            
                                                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white border-b pb-4 dark:border-gray-700">Detalles de Solicitud</h3>
                                                            
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div><p class="text-xs text-gray-500 font-bold uppercase dark:text-gray-400">Tipo</p><p class="text-base capitalize font-medium text-gray-900 dark:text-white">{{ $ausencia->type }}</p></div>
                                                                <div><p class="text-xs text-gray-500 font-bold uppercase dark:text-gray-400">Estado</p><p class="text-base capitalize font-medium text-gray-900 dark:text-white">{{ $ausencia->status }}</p></div>
                                                            </div>

                                                            <div>
                                                                <p class="text-xs text-gray-500 font-bold uppercase mb-1 dark:text-gray-400">Motivo</p>
                                                                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-sm italic text-gray-700 dark:text-gray-300">
                                                                    "{{ $ausencia->reason }}"
                                                                </div>
                                                            </div>

                                                            @if($ausencia->admin_response) 
                                                                <div>
                                                                    <p class="text-xs text-blue-600 font-bold uppercase mb-1 dark:text-blue-400">Respuesta de RRHH</p>
                                                                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl text-sm text-blue-800 dark:text-blue-300">
                                                                        {{ $ausencia->admin_response }}
                                                                    </div>
                                                                </div> 
                                                            @endif

                                                            <div class="text-right pt-4">
                                                                <!-- BOTÓN CERRAR CON ALTO CONTRASTE -->
                                                                <button @click="showDetailModal = false" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded-xl transition-colors dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 shadow-lg">
                                                                    Cerrar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-lg font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                                            No se encontraron solicitudes.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $ausencias->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL SOLICITAR AUSENCIA (Reutilizado) -->
        <div x-show="showLeaveModal" style="display: none;" x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 transition-opacity"
             @click="showLeaveModal = false"> <!-- Clic fuera cierra -->
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100" @click.stop>
                <div class="bg-purple-600 p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Solicitar Ausencia
                    </h3>
                    <button @click="showLeaveModal = false" class="text-purple-100 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('ausencias.store', Auth::id()) }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
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