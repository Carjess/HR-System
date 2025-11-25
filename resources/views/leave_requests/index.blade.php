<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Solicitudes de Ausencia') }}
        </h2>
        
        <style>
            /* Animaciones globales */
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

                <!-- Mensaje de estado -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 text-base border border-green-300 rounded-xl shadow-sm dark:bg-green-900/50 dark:text-green-300 dark:border-green-800">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Controles: Búsqueda y Filtros -->
                <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-8">
                    <form method="GET" action="{{ route('ausencias.index') }}" class="sm:flex sm:items-center gap-4 w-full">
                        
                        <!-- Búsqueda por Nombre -->
                        <div class="relative w-full sm:w-96">
                            <input placeholder="Buscar empleado..." 
                                   class="input shadow-sm hover:shadow-md focus:shadow-lg focus:border-2 border-gray-300 px-5 py-3 rounded-xl w-full transition-all outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400 font-medium text-base" 
                                   name="search" 
                                   type="search" 
                                   value="{{ $filters['search'] ?? '' }}" />
                            <svg class="size-6 absolute top-3.5 right-4 text-gray-400 dark:text-gray-500 w-6 h-6 pointer-events-none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linejoin="round" stroke-linecap="round"></path></svg>
                        </div>

                        <!-- Filtro por Estado -->
                        <div class="w-full sm:w-64">
                            <select name="status" id="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl shadow-sm hover:shadow-md focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-medium transition-shadow">
                                <option value="">Todos los Estados</option>
                                <option value="pendiente" {{ ($filters['status'] ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobado" {{ ($filters['status'] ?? '') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rechazado" {{ ($filters['status'] ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        
                        <!-- Botón de Filtrar -->
                        <button type="submit" class="btn-anim w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-base px-8 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-md">
                            Filtrar
                        </button>
                    </form>
                </div>

                <!-- TABLA DE SOLICITUDES -->
                <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                    <table class="w-full text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 uppercase font-bold tracking-wider bg-gray-100 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 pl-8">Empleado</th>
                                <th scope="col" class="px-6 py-4 hidden sm:table-cell">Fechas</th>
                                <th scope="col" class="px-6 py-4">Motivo</th>
                                <th scope="col" class="px-6 py-4">Estado</th>
                                <th scope="col" class="px-6 py-4 text-right pr-8">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($requests as $request)
                                <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                    x-data="{ showModal: false }"
                                    @click="showModal = true">
                                    
                                    <!-- Empleado -->
                                    <td class="px-6 py-6 pl-8 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400 font-bold text-lg shadow-sm border border-purple-100 dark:border-purple-800">
                                                {{ substr($request->employee->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('empleados.show', $request->employee->id) }}" 
                                                   onclick="event.stopPropagation()"
                                                   class="text-lg font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors block leading-tight">
                                                    {{ $request->employee->name }}
                                                </a>
                                                <!-- Puesto del empleado -->
                                                <div class="font-normal text-gray-500 dark:text-gray-400 text-sm mt-1">
                                                    {{ $request->employee->position->name ?? 'Sin puesto' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Fechas -->
                                    <td class="px-6 py-6 hidden sm:table-cell">
                                        <div class="text-base text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1 }} días
                                        </div>
                                    </td>

                                    <!-- Motivo (Truncado) -->
                                    <td class="px-6 py-6">
                                        <p class="text-base text-gray-700 dark:text-gray-300 truncate max-w-xs" title="{{ $request->reason }}">
                                            {{ $request->reason ?? 'Sin motivo especificado' }}
                                        </p>
                                    </td>

                                    <!-- Estado -->
                                    <td class="px-6 py-6">
                                        @if($request->status === 'aprobado')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800">
                                                Aprobado
                                            </span>
                                        @elseif($request->status === 'rechazado')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800">
                                                Rechazado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Botón Detalles -->
                                    <td class="px-6 py-6 text-right pr-8">
                                        <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 hover:underline font-bold text-sm transition-colors">
                                            Ver Detalles
                                        </button>

                                        <!-- ==================== VENTANA MODAL (Teleported) ==================== -->
                                        <template x-teleport="body">
                                            <div x-show="showModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left">
                                                
                                                <div class="relative w-full max-w-2xl h-auto max-h-full overflow-y-auto" @click.away="showModal = false">
                                                    <!-- Contenido del Modal -->
                                                    <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                        
                                                        <!-- Cabecera -->
                                                        <div class="flex items-start justify-between p-6 border-b rounded-t-xl dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                                                Detalles de Solicitud
                                                            </h3>
                                                            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            </button>
                                                        </div>

                                                        <!-- SI LA SOLICITUD ESTÁ PENDIENTE: Muestra Formulario -->
                                                        @if($request->status === 'pendiente')
                                                        <form method="POST" class="p-8 space-y-6">
                                                            @csrf
                                                            @method('PATCH')

                                                            <!-- Info Resumida -->
                                                            <div class="grid grid-cols-2 gap-6">
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleado</p>
                                                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $request->employee->name }}</p>
                                                                    <p class="text-sm text-gray-500">{{ $request->employee->position->name ?? 'Sin puesto' }}</p>
                                                                </div>
                                                                <div class="text-right">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800">
                                                                        Pendiente
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Fechas -->
                                                            <div class="grid grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-700/50 p-5 rounded-xl border border-gray-100 dark:border-gray-600">
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Inicio</p>
                                                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Fin</p>
                                                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Motivo -->
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Motivo de la solicitud</p>
                                                                <div class="p-4 border rounded-xl bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-base leading-relaxed break-words whitespace-normal">
                                                                    {{ $request->reason ?? 'Sin motivo especificado.' }}
                                                                </div>
                                                            </div>

                                                            <!-- Respuesta del Admin -->
                                                            <div>
                                                                <label for="admin_response_{{ $request->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Respuesta / Motivo (Opcional)</label>
                                                                <textarea name="admin_response" id="admin_response_{{ $request->id }}" rows="3" class="block p-4 w-full text-base text-gray-900 bg-gray-50 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Escribe aquí una razón para aprobar o rechazar..."></textarea>
                                                            </div>

                                                            <!-- Botones de Acción -->
                                                            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                                                <button type="submit" formaction="{{ route('ausencias.reject', $request->id) }}" class="text-gray-700 bg-white border border-gray-300 hover:bg-red-50 hover:text-red-700 hover:border-red-300 focus:ring-4 focus:outline-none focus:ring-red-100 font-semibold rounded-xl text-base px-6 py-3 transition-colors dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:text-red-400 dark:hover:bg-gray-700" onclick="return confirm('¿Seguro que quieres rechazar esta solicitud?')">
                                                                    Rechazar
                                                                </button>
                                                                <button type="submit" formaction="{{ route('ausencias.approve', $request->id) }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-bold rounded-xl text-base px-8 py-3 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors shadow-md">
                                                                    Aprobar Solicitud
                                                                </button>
                                                            </div>
                                                        </form>

                                                        <!-- SI LA SOLICITUD YA FUE PROCESADA: Muestra solo info -->
                                                        @else
                                                            <div class="p-8 space-y-8">
                                                                <!-- Resumen Info (Igual que arriba) -->
                                                                <div class="grid grid-cols-2 gap-6">
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleado</p>
                                                                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $request->employee->name }}</p>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        @if($request->status === 'aprobado')
                                                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-green-100 text-green-800 border border-green-200 dark:bg-green-900/50 dark:text-green-300 dark:border-green-800">Aprobado</span>
                                                                        @else
                                                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-800 border border-red-200 dark:bg-red-900/50 dark:text-red-300 dark:border-red-800">Rechazado</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="grid grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-700/50 p-5 rounded-xl border border-gray-100 dark:border-gray-600">
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Inicio</p>
                                                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Fin</p>
                                                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
                                                                    </div>
                                                                </div>

                                                                <div>
                                                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Motivo de la solicitud</p>
                                                                    <div class="p-5 border rounded-xl bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-base leading-relaxed break-words whitespace-normal shadow-sm">
                                                                        {{ $request->reason ?? 'Sin motivo especificado.' }}
                                                                    </div>
                                                                </div>

                                                                @if($request->admin_response)
                                                                    <div>
                                                                        <p class="text-sm font-bold text-blue-700 dark:text-blue-300 mb-2 uppercase tracking-wide">Respuesta de la Empresa</p>
                                                                        <div class="p-5 border rounded-xl bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800 text-gray-800 dark:text-blue-100 text-base leading-relaxed break-words whitespace-normal shadow-sm">
                                                                            {{ $request->admin_response }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="flex items-center justify-end p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                                                                <button @click="showModal = false" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-semibold rounded-xl text-base px-8 py-3 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 transition-colors shadow-sm">
                                                                    Cerrar
                                                                </button>
                                                            </div>
                                                        @endif
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