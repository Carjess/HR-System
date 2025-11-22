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
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            /* Clase para celdas clicables específicas (si las usáramos) */
            .clickable-cell:hover { background-color: rgba(59, 130, 246, 0.05); }
            .dark .clickable-cell:hover { background-color: rgba(59, 130, 246, 0.1); }
        </style>
    </x-slot>

    {{-- x-data para el modal de crear empleado --}}
    <div class="" x-data="{ showCreateModal: {{ $errors->any() && !$errors->has('id') ? 'true' : 'false' }} }">
        <div class="w-full">
            
            <!-- 1. Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Total Empleados -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 transition hover:shadow-xl">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Empleados</p>
                                <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalEmpleados }}</p>
                            </div>
                            <div class="p-4 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contratos Activos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 transition hover:shadow-xl">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contratos Activos</p>
                                <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalContratosActivos }}</p>
                            </div>
                            <div class="p-4 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horas este Mes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 transition hover:shadow-xl">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Horas (Este Mes)</p>
                                <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($horasEsteMes, 1) }}</p>
                            </div>
                            <div class="p-4 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- 2. Accesos Directos -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 h-full">
                        <div class="p-8 text-gray-900 dark:text-gray-100 flex flex-col h-full">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                Accesos Rápidos
                            </h3>
                            
                            <div class="flex flex-col gap-4 flex-grow">
                                
                                <button @click="showCreateModal = true" class="flex items-center justify-between px-6 py-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-bold rounded-xl transition-all group btn-anim text-left w-full">
                                    <span class="flex items-center gap-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        Añadir Empleado
                                    </span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>

                                <a href="{{ route('payroll.index') }}" class="flex items-center justify-between px-6 py-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 text-green-700 dark:text-green-300 font-bold rounded-xl transition-all group btn-anim">
                                    <span class="flex items-center gap-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Correr Nómina
                                    </span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>

                                <a href="{{ route('tipos-contrato.index') }}" class="flex items-center justify-between px-6 py-4 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-all group btn-anim">
                                    <span class="flex items-center gap-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Ver Contratos
                                    </span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Tabla de Contrataciones Recientes (INTEGRADA Y LIMPIA) -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 h-full">
                        <div class="p-8 text-gray-900 dark:text-gray-100">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                Contrataciones Recientes
                            </h3>
                            
                            <!-- CAMBIO: Eliminadas clases de borde y sombra extra. Solo queda overflow-x-auto. -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-sm text-gray-700 uppercase bg-gray-100 dark:bg-gray-700/50 dark:text-gray-300 font-bold tracking-wider">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 rounded-l-lg">Empleado</th>
                                            <th scope="col" class="px-6 py-4">Puesto</th>
                                            <th scope="col" class="px-6 py-4 hidden sm:table-cell">Fecha</th>
                                            <th scope="col" class="px-6 py-4 text-right rounded-r-lg">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($empleadosRecientes as $empleado)
                                            <!-- Fila Interactiva: Clic lleva al perfil -->
                                            <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                                onclick="window.location.href='{{ route('empleados.show', $empleado->id) }}'"
                                                x-data="{ showEditModal: {{ $errors->has('id') && old('id') == $empleado->id ? 'true' : 'false' }} }">
                                                
                                                <!-- Empleado -->
                                                <td class="px-6 py-5 whitespace-nowrap">
                                                    <div class="flex items-center gap-4">
                                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-bold text-lg border border-blue-200 dark:border-blue-800">
                                                            {{ substr($empleado->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('empleados.show', $empleado->id) }}" class="text-base font-bold text-gray-900 dark:text-white hover:underline hover:text-blue-600 block leading-tight">
                                                                {{ $empleado->name }}
                                                            </a>
                                                            <div class="font-normal text-gray-500 dark:text-gray-400 text-xs mt-1">{{ $empleado->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Puesto -->
                                                <td class="px-6 py-5 text-base text-gray-900 dark:text-white font-medium">{{ $empleado->position->name ?? 'N/A' }}</td>

                                                <!-- Fecha -->
                                                <td class="px-6 py-5 text-base hidden sm:table-cell">{{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d M, Y') }}</td>
                                                
                                                <!-- ACCIONES (Con stopPropagation) -->
                                                <td class="px-6 py-5 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        
                                                        <!-- Botón Editar -->
                                                        <button @click.stop="showEditModal = true" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all" title="Editar">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                        </button>
                                                        
                                                        <!-- Botón Eliminar -->
                                                        <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" onclick="event.stopPropagation(); return confirm('¿Eliminar?')" title="Eliminar">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- MODAL EDITAR (Teleported) -->
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

        <!-- MODAL CREAR (Reutilizamos el diseño del form) -->
        <div x-show="showCreateModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
            <div class="relative w-full max-w-4xl h-auto max-h-full overflow-y-auto" @click.away="showCreateModal = false">
                <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Añadir Nuevo Empleado</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('empleados.store') }}" class="p-8">
                        @csrf 
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Datos Personales</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nombre Completo</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                @if($errors->has('name') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span> @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                @if($errors->has('email') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span> @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Teléfono</label>
                                <input type="tel" name="telefono" value="{{ old('telefono') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Dirección</label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 border-b pb-3 dark:border-gray-700">Información Laboral</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Fecha Ingreso</label>
                                <input type="date" name="fecha_contratacion" value="{{ old('fecha_contratacion', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Departamento</label>
                                <select name="department_id" onchange="loadPositions(this.value, 'create_position_id')" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Cargo</label>
                                <select name="position_id" id="create_position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" disabled>
                                    <option value="">-- Selecciona Dept primero --</option>
                                </select>
                                @if($errors->has('position_id') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('position_id') }}</span> @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Contraseña</label>
                                <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                @if($errors->has('password') && !$errors->has('id')) <span class="text-red-600 text-sm">{{ $errors->first('password') }}</span> @endif
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button @click="showCreateModal = false" type="button" class="text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-6 py-3 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white transition-colors">Cancelar</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-6 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                            positionSelect.innerHTML = '<option value="">No hay cargos</option>';
                        }
                    })
                    .catch(error => {
                        positionSelect.innerHTML = '<option value="">Error</option>';
                    });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept primero --</option>';
                positionSelect.disabled = true;
            }
        }
    </script>
</x-app-layout>