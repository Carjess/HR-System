<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

        <style>
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #ffffff; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }
        </style>
    </x-slot>

    {{-- x-data para el modal de crear empleado --}}
    <div class="" x-data="{ showCreateModal: {{ $errors->any() && !$errors->has('id') ? 'true' : 'false' }} }">
        
        <!-- CORRECCIÓN: Agregamos 'relative z-0' para aislar las tarjetas y que no tapen el menú del perfil -->
        <div class="w-full relative z-0">
            
            <!-- 1. TARJETAS DE ESTADÍSTICAS (ESTILO PREMIUM UNIFICADO) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                
                <!-- CARD 1: Total Empleados -->
                <div class="bg-gradient-to-br from-primary-800 to-primary-900 rounded-2xl shadow-xl border border-primary-700/50 relative overflow-hidden group">
                    <!-- Decoración de fondo sutil -->
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-primary-200 uppercase tracking-wider mb-1">Total Empleados</p>
                                <p class="text-5xl font-bold text-white">{{ $totalEmpleados }}</p>
                            </div>
                            <!-- Icono -->
                            <div class="p-3 rounded-xl bg-white/10 text-white backdrop-blur-sm border border-white/10 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-primary-100 font-medium opacity-80">
                            <svg class="w-3 h-3 mr-1 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Activos en nómina
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Contratos Activos -->
                <div class="bg-gradient-to-br from-primary-800 to-primary-900 rounded-2xl shadow-xl border border-primary-700/50 relative overflow-hidden group">
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-emerald-500 opacity-10 rounded-full blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-primary-200 uppercase tracking-wider mb-1">Contratos Activos</p>
                                <p class="text-5xl font-bold text-white">{{ $totalContratosActivos }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-emerald-500/20 text-emerald-200 backdrop-blur-sm border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-primary-100 font-medium opacity-80">
                            Personal con contrato vigente
                        </div>
                    </div>
                </div>

                <!-- CARD 3: Horas este Mes (COLOR CORREGIDO) -->
                <div class="bg-gradient-to-br from-primary-800 to-primary-900 rounded-2xl shadow-xl border border-primary-700/50 relative overflow-hidden group">
                    <!-- Decoración cambiada a Esmeralda/Blanco para coincidir -->
                    <div class="absolute top-0 left-0 -mt-4 -ml-4 w-24 h-24 bg-emerald-500 opacity-10 rounded-full blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-primary-200 uppercase tracking-wider mb-1">Horas (Este Mes)</p>
                                <p class="text-5xl font-bold text-white">{{ number_format($horasEsteMes, 1) }}</p>
                            </div>
                            <!-- Icono cambiado de Violeta a Esmeralda -->
                            <div class="p-3 rounded-xl bg-emerald-500/20 text-emerald-200 backdrop-blur-sm border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-primary-100 font-medium opacity-80">
                            Acumulado del periodo actual
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN INFERIOR (ACCESOS Y TABLAS) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- COLUMNA IZQUIERDA -->
                <div class="lg:col-span-1 space-y-8">
                    
                    <!-- 1. Accesos Rápidos -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="w-1 h-6 bg-primary-500 rounded-full"></span>
                                Accesos Rápidos
                            </h3>
                            <div class="flex flex-col gap-3">
                                <!-- Botón Añadir -->
                                <button @click="showCreateModal = true" class="flex items-center justify-between px-4 py-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-bold rounded-lg transition-all group border border-blue-100 dark:border-blue-800 text-sm">
                                    <span class="flex items-center gap-3">
                                        <div class="p-1.5 bg-white dark:bg-blue-800 rounded-md shadow-sm text-blue-600 dark:text-blue-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg></div>
                                        Añadir Empleado
                                    </span>
                                </button>
                                <!-- Botón Nómina -->
                                <a href="{{ route('payroll.index') }}" class="flex items-center justify-between px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-bold rounded-lg transition-all group border border-emerald-100 dark:border-emerald-800 text-sm">
                                    <span class="flex items-center gap-3">
                                        <div class="p-1.5 bg-white dark:bg-emerald-800 rounded-md shadow-sm text-emerald-600 dark:text-emerald-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                                        Correr Nómina
                                    </span>
                                </a>
                                <!-- Botón Contratos -->
                                <a href="{{ route('tipos-contrato.index') }}" class="flex items-center justify-between px-4 py-3 bg-violet-50 dark:bg-violet-900/20 hover:bg-violet-100 dark:hover:bg-violet-900/40 text-violet-700 dark:text-violet-300 font-bold rounded-lg transition-all group border border-violet-100 dark:border-violet-800 text-sm">
                                    <span class="flex items-center gap-3">
                                        <div class="p-1.5 bg-white dark:bg-violet-800 rounded-md shadow-sm text-violet-600 dark:text-violet-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                        Ver Contratos
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Gráfico de Distribución (DINÁMICO) -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-6 text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-1 h-6 bg-primary-500 rounded-full"></span>
                                Distribución Personal
                            </h3>
                            
                            <!-- Contenedor del Gráfico Dinámico -->
                            <div class="h-48 flex items-end justify-around gap-2 pt-6 px-2">
                                @if(isset($deptStats) && count($deptStats) > 0)
                                    @foreach($deptStats as $stat)
                                        <div class="w-1/4 flex flex-col items-center group relative h-full justify-end">
                                            <!-- Tooltip -->
                                            <div class="absolute -top-8 bg-gray-900 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity mb-1 whitespace-nowrap z-10">
                                                {{ $stat['count'] }} Empleados
                                            </div>
                                            <!-- Barra -->
                                            <div class="w-full rounded-t-lg transition-all duration-1000 group-hover:opacity-80 relative" 
                                                 style="height: {{ $stat['percentage'] }}%; background-color: {{ $stat['color'] }}; min-height: 10%;">
                                                <span class="absolute -top-5 left-1/2 transform -translate-x-1/2 text-xs font-bold text-gray-600 dark:text-gray-400">
                                                    {{ $stat['percentage'] }}%
                                                </span>
                                            </div>
                                            <!-- Etiqueta -->
                                            <span class="text-xs font-medium text-gray-500 mt-2 truncate w-full text-center" title="{{ $stat['name'] }}">
                                                {{ \Illuminate\Support\Str::limit($stat['name'], 8) }}
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm text-center">
                                        No hay datos suficientes para generar la gráfica.
                                    </div>
                                @endif
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 mt-0"></div>
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA (Tabla Contrataciones) -->
                <div class="lg:col-span-2 h-full">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 h-full flex flex-col">
                        <div class="p-8 text-gray-900 dark:text-gray-100 flex-grow">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                Contrataciones Recientes
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-sm text-white uppercase bg-primary-600 dark:bg-primary-900/50 font-bold tracking-wider">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 rounded-l-lg">Empleado</th>
                                            <th scope="col" class="px-6 py-4">Puesto</th>
                                            <th scope="col" class="px-6 py-4 hidden sm:table-cell">Fecha</th>
                                            <th scope="col" class="px-6 py-4 text-right rounded-r-lg">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($empleadosRecientes as $empleado)
                                            <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                                onclick="window.location.href='{{ route('empleados.show', $empleado->id) }}'"
                                                x-data="{ showEditModal: {{ $errors->has('id') && old('id') == $empleado->id ? 'true' : 'false' }} }">
                                                
                                                <td class="px-6 py-5 whitespace-nowrap">
                                                    <div class="flex items-center gap-4">
                                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-300 font-bold text-lg border border-primary-200 dark:border-primary-800">
                                                            {{ substr($empleado->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('empleados.show', $empleado->id) }}" class="text-base font-bold text-gray-900 dark:text-white hover:underline hover:text-primary-600 block leading-tight">
                                                                {{ $empleado->name }}
                                                            </a>
                                                            <div class="font-normal text-gray-500 dark:text-gray-400 text-xs mt-1">{{ $empleado->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-5 text-base text-gray-900 dark:text-white font-medium">
                                                    {{ $empleado->position->name ?? 'Sin Cargo' }}
                                                </td>

                                                <td class="px-6 py-5 text-base hidden sm:table-cell">
                                                    @if($empleado->fecha_contratacion)
                                                        {{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d M, Y') }}
                                                    @else
                                                        {{ $empleado->created_at->format('d M, Y') }} <span class="text-xs text-gray-400">(Reg)</span>
                                                    @endif
                                                </td>
                                                
                                                <td class="px-6 py-5 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button @click.stop="showEditModal = true" class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2 rounded-full hover:bg-primary-50 dark:hover:bg-gray-700 transition-all" title="Editar">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                        </button>
                                                        <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" onclick="event.stopPropagation(); return confirm('¿Estás seguro de eliminar este empleado?')" title="Eliminar">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    
                                                    <!-- MODAL EDITAR (Integrado en el Loop) -->
                                                    <template x-teleport="body">
                                                        <div x-show="showEditModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left" @click.stop="">
                                                            <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showEditModal = false">
                                                                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                                    <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Editar Empleado: {{ $empleado->name }}</h3>
                                                                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                                        </button>
                                                                    </div>
                                                                    @include('empleados.partials.edit-form', ['empleado' => $empleado])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-10 text-center text-lg text-gray-500 dark:text-gray-400">No hay contrataciones recientes.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CREAR NUEVO EMPLEADO -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Añadir Nuevo Empleado</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    
                    <!-- Formulario de Creación -->
                    <form method="POST" action="{{ route('empleados.store') }}" class="p-8">
                        @csrf 
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Datos Personales</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nombre Completo</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Teléfono</label>
                                <input type="tel" name="telefono" value="{{ old('telefono') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Dirección</label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Información Laboral</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Fecha Ingreso</label>
                                <input type="date" name="fecha_contratacion" value="{{ old('fecha_contratacion', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Departamento</label>
                                <select name="department_id" onchange="loadPositions(this.value, 'create_position_id')" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Cargo</label>
                                <select name="position_id" id="create_position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" disabled required>
                                    <option value="">-- Selecciona Dept primero --</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Contraseña</label>
                                <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button @click="showCreateModal = false" type="button" class="text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-base px-6 py-3 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white transition-colors">Cancelar</button>
                            <button type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-base px-6 py-3 dark:bg-primary-600 dark:hover:bg-primary-700 transition-colors">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para cargar Cargos dinámicamente -->
    <script>
        function loadPositions(deptId, targetSelectId) {
            var positionSelect = document.getElementById(targetSelectId);
            positionSelect.innerHTML = '<option value="">Cargando...</option>';
            positionSelect.disabled = true;

            if (deptId) {
                fetch('/api/departamentos/' + deptId + '/cargos')
                    .then(response => response.json())
                    .then(data => {
                        positionSelect.innerHTML = '<option value="">-- Selecciona --</option>';
                        if(data.length > 0){
                            data.forEach(position => {
                                var option = document.createElement('option');
                                option.value = position.id;
                                option.text = position.name;
                                positionSelect.appendChild(option);
                            });
                            positionSelect.disabled = false;
                        } else {
                            positionSelect.innerHTML = '<option value="">No hay cargos en este Depto</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        positionSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept primero --</option>';
                positionSelect.disabled = true;
            }
        }
    </script>
</x-app-layout>