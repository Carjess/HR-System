<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Solicitudes de Ausencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de estado -->
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded dark:bg-green-900 dark:text-green-300 dark:border-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Controles: Búsqueda y Filtros -->
                    <div class="gap-4 sm:flex sm:items-center sm:justify-between mb-6">
                        <form method="GET" action="{{ route('ausencias.index') }}" class="sm:flex sm:items-center gap-4 w-full">
                            
                            <!-- Búsqueda por Nombre de Empleado -->
                            <div class="w-full sm:w-1/3">
                                <label for="search" class="sr-only">Buscar</label>
                                <input type="text" name="search" id="search"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       placeholder="Buscar empleado..."
                                       value="{{ $filters['search'] ?? '' }}">
                            </div>

                            <!-- Filtro por Estado -->
                            <div>
                                <select name="status" id="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:min-w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Todos los Estados</option>
                                    <option value="pendiente" {{ ($filters['status'] ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="aprobado" {{ ($filters['status'] ?? '') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rechazado" {{ ($filters['status'] ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                            
                            <!-- Botón de Filtrar -->
                            <button type="submit" class="mt-2 sm:mt-0 w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Filtrar</button>
                        </form>
                    </div>

                    <!-- Lista de Solicitudes -->
                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($requests as $request)
                                {{-- x-data maneja el estado del modal --}}
                                <div x-data="{ showModal: false }" class="flex flex-wrap items-center gap-y-4 py-6">
                                    
                                    <!-- Empleado -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleado:</dt>
                                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('empleados.show', $request->employee->id) }}" class="hover:underline text-blue-500">
                                                {{ $request->employee->name }}
                                            </a>
                                        </dd>
                                    </dl>

                                    <!-- Fechas -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Desde:</dt>
                                        <dd class="mt-1.5 text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}
                                        </dd>
                                    </dl>
                                    
                                    <!-- Hasta -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hasta:</dt>
                                        <dd class="mt-1.5 text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}
                                        </dd>
                                    </dl>

                                    <!-- Estado (Badge) -->
                                    <dl class="w-1/2 sm:w-auto lg:flex-none mr-6">
                                        <dt class="sr-only">Estado</dt>
                                        <dd class="mt-1.5">
                                            @if($request->status === 'aprobado')
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Aprobado</span>
                                            @elseif($request->status === 'rechazado')
                                                <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Rechazado</span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Pendiente</span>
                                            @endif
                                        </dd>
                                    </dl>

                                    <!-- Botón VER DETALLES (Abre el Modal) -->
                                    <div class="w-full sm:w-auto flex items-center justify-end gap-2">
                                        <button @click="showModal = true" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">
                                            Ver Detalles
                                        </button>
                                    </div>

                                    <!-- ==================== VENTANA MODAL ==================== -->
                                    <div x-show="showModal" 
                                         style="display: none;"
                                         class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 md:h-full">
                                        
                                        <div class="relative w-full h-full max-w-2xl md:h-auto" @click.away="showModal = false">
                                            <!-- Contenido del Modal -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                                                
                                                <!-- Cabecera del Modal -->
                                                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Detalles de Solicitud
                                                    </h3>
                                                    <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        <span class="sr-only">Cerrar modal</span>
                                                    </button>
                                                </div>

                                                <!-- SI LA SOLICITUD ESTÁ PENDIENTE: Muestra Formulario -->
                                                @if($request->status === 'pendiente')
                                                <form method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="p-6 space-y-6">
                                                        <!-- Info del Empleado -->
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleado</p>
                                                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $request->employee->name }}</p>
                                                                <p class="text-sm text-gray-500">{{ $request->employee->position->name ?? 'Sin puesto' }}</p>
                                                            </div>
                                                            <div class="text-right">
                                                                <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Pendiente</span>
                                                            </div>
                                                        </div>

                                                        <!-- Info de Fechas -->
                                                        <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Inicio</p>
                                                                <p class="text-base font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Fin</p>
                                                                <p class="text-base font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
                                                            </div>
                                                        </div>

                                                        <!-- Motivo del Empleado (Fix de texto) -->
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Motivo de la solicitud</p>
                                                            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-sm leading-relaxed break-words whitespace-normal">
                                                                {{ $request->reason ?? 'Sin motivo especificado.' }}
                                                            </div>
                                                        </div>

                                                        <!-- Respuesta del Admin -->
                                                        <div>
                                                            <label for="admin_response_{{ $request->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Respuesta / Motivo (Opcional)</label>
                                                            <textarea name="admin_response" id="admin_response_{{ $request->id }}" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aquí una razón para aprobar o rechazar..."></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Botones de Acción (Usando formaction) -->
                                                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button type="submit" formaction="{{ route('ausencias.approve', $request->id) }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                            Aprobar Solicitud
                                                        </button>
                                                        <button type="submit" formaction="{{ route('ausencias.reject', $request->id) }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" onclick="return confirm('¿Seguro que quieres rechazar esta solicitud?')">
                                                            Rechazar
                                                        </button>
                                                    </div>
                                                </form>

                                                <!-- SI LA SOLICITUD YA FUE PROCESADA: Muestra solo info -->
                                                @else
                                                    <div class="p-6 space-y-6">
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleado</p>
                                                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $request->employee->name }}</p>
                                                            </div>
                                                            <div class="text-right">
                                                                @if($request->status === 'aprobado')
                                                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Aprobado</span>
                                                                @else
                                                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Rechazado</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Inicio</p>
                                                                <p class="text-base font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Fin</p>
                                                                <p class="text-base font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Motivo de la solicitud</p>
                                                            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-sm leading-relaxed break-words whitespace-normal">
                                                                {{ $request->reason ?? 'Sin motivo especificado.' }}
                                                            </div>
                                                        </div>

                                                        <!-- MOSTRAR RESPUESTA DEL ADMIN SI EXISTE -->
                                                        @if($request->admin_response)
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Respuesta del Administrador</p>
                                                                <div class="p-4 border rounded-lg bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-gray-900 dark:text-white text-sm leading-relaxed break-words whitespace-normal">
                                                                    {{ $request->admin_response }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="flex items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button @click="showModal = false" class="ml-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Cerrar</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ==================== FIN MODAL ==================== -->

                                </div>
                            @empty
                                <div class="py-10 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">No hay solicitudes de ausencia registradas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Paginación (Redonda) -->
                    <div class="mt-6">
                        {{ $requests->appends($filters)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>