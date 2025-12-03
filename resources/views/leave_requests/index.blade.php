<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Solicitudes') }}
        </h2>
        
        <style>
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration { display: none; }
        </style>
    </x-slot>

    <div class="w-full">
        <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                @if (session('status'))
                    <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 text-base border border-emerald-300 rounded-xl shadow-sm dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Controles: Búsqueda y Filtros -->
                <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                    <form method="GET" action="{{ route('ausencias.index') }}" class="sm:flex sm:items-center gap-4 w-full">
                        
                        <!-- Búsqueda por Nombre -->
                        <div class="relative w-full sm:w-96">
                            <input placeholder="Buscar empleado..." 
                                   class="input shadow-sm hover:shadow-md focus:shadow-lg focus:ring-2 focus:ring-primary-500 border-gray-300 px-5 py-3 rounded-xl w-full transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium text-base" 
                                   name="search" 
                                   type="search" 
                                   value="{{ $filters['search'] ?? '' }}" />
                            <svg class="size-6 absolute top-3 right-4 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                        </div>

                        <!-- Filtro por Estado -->
                        <div class="w-full sm:w-64">
                            <select name="status" id="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm hover:shadow-md focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-medium transition-shadow cursor-pointer">
                                <option value="">Todos los Estados</option>
                                <option value="pendiente" {{ ($filters['status'] ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobado" {{ ($filters['status'] ?? '') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rechazado" {{ ($filters['status'] ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        
                        <!-- Botón de Filtrar (AZUL) -->
                        <button type="submit" class="btn-anim w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-md">
                            Filtrar
                        </button>
                    </form>
                </div>

                <!-- TABLA DE SOLICITUDES -->
                <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                    <table class="w-full text-left text-gray-500 dark:text-gray-400">
                        <!-- HEADER VERDE PETRÓLEO (Primary-600) -->
                        <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 pl-8">Empleado</th>
                                <th scope="col" class="px-6 py-4 hidden sm:table-cell">Fechas</th>
                                <th scope="col" class="px-6 py-4">Motivo</th>
                                <th scope="col" class="px-6 py-4">Estado</th>
                                <th scope="col" class="px-6 py-4 text-right pr-8">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($requests as $request)
                                <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                    x-data="{ showModal: false }"
                                    @click="showModal = true">
                                    
                                    <!-- Empleado -->
                                    <td class="px-6 py-5 pl-8 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-300 font-bold text-lg shadow-sm border border-primary-100 dark:border-primary-800">
                                                {{ substr($request->employee->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <!-- Enlace al perfil -->
                                                <a href="{{ route('empleados.show', $request->employee->id) }}" 
                                                   onclick="event.stopPropagation()"
                                                   class="text-lg font-bold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors block leading-tight">
                                                    {{ $request->employee->name }}
                                                </a>
                                                <div class="font-normal text-gray-500 dark:text-gray-400 text-sm mt-1">
                                                    {{ $request->employee->position->name ?? 'Sin puesto' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Fechas -->
                                    <td class="px-6 py-5 hidden sm:table-cell">
                                        <div class="text-base text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs font-bold text-primary-600 dark:text-primary-400 mt-1 bg-primary-50 dark:bg-primary-900/20 inline-block px-2 py-0.5 rounded-md border border-primary-100 dark:border-primary-800">
                                            {{ \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1 }} días
                                        </div>
                                    </td>

                                    <!-- Motivo (Truncado) -->
                                    <td class="px-6 py-5">
                                        <p class="text-base text-gray-700 dark:text-gray-300 truncate max-w-xs" title="{{ $request->reason }}">
                                            {{ $request->reason ?? 'Sin motivo especificado' }}
                                        </p>
                                    </td>

                                    <!-- Estado -->
                                    <td class="px-6 py-5">
                                        @if($request->status === 'aprobado')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 shadow-sm">
                                                Aprobado
                                            </span>
                                        @elseif($request->status === 'rechazado')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 shadow-sm">
                                                Rechazado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:border-yellow-800 shadow-sm">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Botón Detalles -->
                                    <td class="px-6 py-5 text-right pr-8">
                                        <button class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2 rounded-full hover:bg-white dark:hover:bg-gray-700 transition-all" title="Ver Detalles">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>

                                        <!-- ==================== VENTANA MODAL ==================== -->
                                        <template x-teleport="body">
                                            <div x-show="showModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4 md:inset-0 h-full text-left transition-opacity duration-300" @click="showModal = false">
                                                
                                                <div class="relative w-full max-w-2xl h-auto max-h-[90vh] overflow-y-auto" @click.stop>
                                                    
                                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700 overflow-hidden">
                                                        
                                                        <!-- Cabecera -->
                                                        <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-900/80">
                                                            <div>
                                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                                    Solicitud #{{ $request->id }}
                                                                    @if($request->status === 'pendiente')
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 border border-yellow-200">Pendiente</span>
                                                                    @elseif($request->status === 'aprobado')
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 border border-green-200">Aprobado</span>
                                                                    @else
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 border border-red-200">Rechazado</span>
                                                                    @endif
                                                                </h3>
                                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Revisa los detalles antes de tomar acción.</p>
                                                            </div>
                                                            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-white hover:text-gray-900 rounded-full p-2 shadow-none hover:shadow-md border border-transparent hover:border-gray-200 dark:hover:bg-gray-700 dark:hover:text-white transition-all">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </div>

                                                        <div class="p-8 space-y-8">
                                                            
                                                            <!-- 
                                                                INFO EMPLEADO (TARJETA INTERNA)
                                                                - CORRECCIÓN: Eliminé 'scale-[1.02]' para evitar el desenfoque.
                                                                - Usamos solo 'hover:shadow-md' y 'border-primary' para destacar sin distorsión.
                                                            -->
                                                            <a href="{{ route('empleados.show', $request->employee->id) }}" 
                                                               class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-200 group cursor-pointer"
                                                               title="Ir al perfil completo">
                                                                
                                                                <div class="h-14 w-14 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-xl border border-primary-100 group-hover:bg-primary-100 transition-colors">
                                                                    {{ substr($request->employee->name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary-700 transition-colors">{{ $request->employee->name }}</h4>
                                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $request->employee->position->name ?? 'Sin Cargo' }} • {{ $request->employee->email }}</p>
                                                                    <p class="text-xs text-primary-500 font-semibold mt-1 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                                                                        Ver Perfil <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                                    </p>
                                                                </div>
                                                            </a>

                                                            <!-- Fechas (Grid) -->
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-600 transition-all duration-200 hover:border-gray-300 hover:shadow-sm cursor-default">
                                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha Inicio</p>
                                                                    <p class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                        {{ \Carbon\Carbon::parse($request->start_date)->format('d M, Y') }}
                                                                    </p>
                                                                </div>
                                                                <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-600 transition-all duration-200 hover:border-gray-300 hover:shadow-sm cursor-default">
                                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha Fin</p>
                                                                    <p class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                        {{ \Carbon\Carbon::parse($request->end_date)->format('d M, Y') }}
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Motivo -->
                                                            <div class="transition-all duration-200 hover:border-gray-300 hover:shadow-sm cursor-default">
                                                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                                                    Motivo de la solicitud
                                                                </p>
                                                                <div class="p-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 text-base leading-relaxed shadow-sm">
                                                                    {{ $request->reason ?? 'Sin motivo especificado.' }}
                                                                </div>
                                                            </div>

                                                            <!-- SI PENDIENTE: Formulario de Acción -->
                                                            @if($request->status === 'pendiente')
                                                                <form method="POST" class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                                                    @csrf
                                                                    @method('PATCH')

                                                                    <div class="mb-6">
                                                                        <label for="admin_response_{{ $request->id }}" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Respuesta / Motivo (Opcional)</label>
                                                                        <textarea name="admin_response" id="admin_response_{{ $request->id }}" rows="3" 
                                                                                  class="block w-full p-4 text-base text-gray-900 bg-gray-50 rounded-xl border border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all" 
                                                                                  placeholder="Escribe una nota para el empleado..."></textarea>
                                                                    </div>

                                                                    <div class="flex items-center justify-end gap-3">
                                                                        <button type="submit" formaction="{{ route('ausencias.reject', $request->id) }}" class="px-6 py-3 text-sm font-bold text-red-600 bg-white border border-red-200 rounded-xl hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-100 transition-all dark:bg-gray-800 dark:border-red-900 dark:text-red-400 dark:hover:bg-gray-700" onclick="return confirm('¿Rechazar solicitud?')">
                                                                            Rechazar
                                                                        </button>
                                                                        <button type="submit" formaction="{{ route('ausencias.approve', $request->id) }}" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transition-all transform hover:scale-105">
                                                                            Aprobar Solicitud
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <!-- SI YA PROCESADA: Mostrar Respuesta -->
                                                                @if($request->admin_response)
                                                                    <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-xl border border-gray-100 dark:border-gray-600 transition-all duration-200 hover:border-gray-300 hover:shadow-sm cursor-default">
                                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Respuesta de Administración</p>
                                                                        <p class="text-gray-700 dark:text-gray-300 italic">"{{ $request->admin_response }}"</p>
                                                                    </div>
                                                                @endif
                                                                
                                                                <div class="flex justify-end pt-4">
                                                                    <button @click="showModal = false" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                                                        Cerrar
                                                                    </button>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-xl font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                                        No hay solicitudes de ausencia registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-10">
                    {{ $requests->appends($filters)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>